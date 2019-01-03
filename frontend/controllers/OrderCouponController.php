<?php

namespace kodi\frontend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\enums\order\OrderType;
use kodi\common\enums\order\PaymentType;
use kodi\common\enums\order\Status;
use kodi\common\models\Order;
use Stripe\Charge;
use Stripe\Stripe;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Cookie;

/**
 * Class `OrderCouponController`
 * =============================
 *
 * This controller is responsible for rendering order coupon page.
 */
class OrderCouponController extends Controller
{
    /**
     * @var array $priceQuantityData
     * quantity => price
     * @TODO: store this data in DB
     */
    public $priceQuantityData = [
        250 => 50,
        500 => 80,
        1000 => 100
    ];
    /**
     * @var int $quantity Default value
     */
    public $quantity = 500;
    /**
     * @var int $priceSticker Price per default sticker
     */
    public $priceSticker = 10;
    /**
     * @var int $priceStickerGeo Price per sticker with geo location
     */
    public $priceStickerGeo = 50;

    /**
     * Displays order page with info about product.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $orderDetails = Yii::$app->request->cookies->getValue('order', [
            'color' => 'yellow',
            'quantity' => $this->quantity,
            'data' => [
                'sticker' => null,
                'sticker_geo' => null
            ],
            'price' => $this->priceQuantityData[$this->quantity]
        ]);

        // If user click pay button
        if ($request->post('color') && $request->post('quantity')) {
            $order = ArrayHelper::merge($orderDetails, [
                'color' => $request->post('color') ?: 'yellow',
                'quantity' => $request->post('quantity') ?: $this->quantity,
                'data' => [
                    'sticker' => $request->post('sticker'),
                    'sticker_geo' => $request->post('sticker_geo')
                ]
            ]);

            $order['price'] = $this->priceQuantityData[$order['quantity']];
            if ($order['data']['sticker']) {
                $order['price'] += $this->priceSticker;
            }
            if ($order['data']['sticker_geo']) {
                $order['price'] += $this->priceStickerGeo;
            }

            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'order',
                'value' => $order,
            ]));

            return $this->redirect(['info']);
        }

        // Means data from cookie used, which we need reformat a bit
        if (empty($orderDetails['price'])) {
            $orderDetails['price'] = $this->priceQuantityData[$orderDetails['quantity']];
            $orderData = Json::decode($orderDetails['order_data']);
            if ($orderData['sticker']) {
                $orderDetails['price'] += $this->priceSticker;
                $orderDetails['data']['sticker'] = true;
            }
            if ($orderData['sticker_geo']) {
                $orderDetails['price'] += $this->priceStickerGeo;
                $orderDetails['data']['sticker_geo'] = true;
            }
        }

        return $this->render('index', [
            'orderDetails' => $orderDetails,
        ]);
    }

    /**
     * Displays order page where user need to type their credentials.
     *
     * @return mixed
     */
    public function actionInfo()
    {
        $model = new Order();
        $order = Yii::$app->request->cookies->getValue('order');
        if (empty($order['color']) || empty($order['quantity'])) {
            return $this->redirect(['/order']);
        }

        // Fill the attributes from stored ones
        $model->setAttributes($order);
        if (!empty($order['data'])) {
            $model->order_data = Json::encode($order['data']);
        }

        // Form data received
        $postData = Yii::$app->request->post();
        if ($model->load($postData) && $model->validate()) {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'order',
                'value' => $model->getAttributes(),
            ]));

            return $this->redirect(['payment']);
        }

        return $this->render('info', [
            'model' => $model,
        ]);
    }

    /**
     * Displays the page with payment method picking
     *
     * @return string|\yii\web\Response
     */
    public function actionPayment()
    {
        $model = new Order();
        $order = Yii::$app->request->cookies->getValue('order');
        $model->setAttributes($order);
        $model->type = OrderType::COUPON;

        if (!$model->validate()) {
            return $this->redirect(['/order/info']);
        }

        $stickerPrice = 0;
        $orderData = Json::decode($order['order_data']);
        if ($orderData['sticker']) {
            $stickerPrice += $this->priceSticker;
        }
        if ($orderData['sticker_geo']) {
            $stickerPrice += $this->priceStickerGeo;
        }

        $price = [
            'sticker' => $stickerPrice,
            'coupon' => $this->priceQuantityData[$model->quantity],
            'total' => $this->priceQuantityData[$model->quantity] + $stickerPrice,
        ];

        $model->total = $price['total'];

        // Handle Wire Transfer choice
        if (Yii::$app->request->post('payment_wiretransfer')) {
            $model->payment_type = PaymentType::WIRETRANSFER;
            $model->status = Status::WAITING;
            if ($model->save()) {
                $bankDetails = Yii::$app->settings->get([
                    'bank_beneficiary',
                    'bank_account_number',
                    'bank_swift_code',
                    'bank_name',
                    'bank_address',
                ]);

                // Remove the order from cookies
                Yii::$app->request->cookies->remove('order');

                return $this->render('payment-wire-success', [
                    'model' => $model,
                    'bankDetails' => $bankDetails,
                ]);
            } else {
                Yii::$app->session->addFlash(AlertType::ERROR, [
                    'message' => Yii::t('frontend', 'Try again later.')
                ]);
            }
        }

        // Handle Credit card choice (Stripe)
        if (Yii::$app->request->post('payment_card') && $token = Yii::$app->request->post('stripe_token')) {
            Stripe::setApiKey(ArrayHelper::getValue(Yii::$app->params, 'billing.stripe.privateKey'));
            $charge = Charge::create([
                'amount' => (int)($model->total . '00'), // last 2 characters required as cents
                'currency' => ArrayHelper::getValue(Yii::$app->params, 'billing.stripe.currency'),
                'description' => 'Kodi Sticker and Coupons order',
                'source' => $token,
            ]);

            if ($charge->id && $charge->paid) {
                $model->payment_type = PaymentType::STRIPE_CARD;
                $model->status = Status::PENDING;
                if ($model->save()) {
                    // Remove the order from cookies
                    Yii::$app->request->cookies->remove('order');

                    return $this->redirect('order-coupon/success');
                }
            }
            Yii::$app->session->addFlash(AlertType::ERROR, [
                'message' => Yii::t('frontend', 'An error occurred. Please, try again later.')
            ]);
        }

        // Handle Bitcoin choice
        if (Yii::$app->request->post('payment_bitcoin')) {

        }

        return $this->render('payment', [
            'model' => $model,
            'price' => $price,
            'stripe' => [
                'key' => ArrayHelper::getValue(Yii::$app->params, 'billing.stripe.publicKey'),
                'currency' => ArrayHelper::getValue(Yii::$app->params, 'billing.stripe.currency'),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionSuccess()
    {
        return $this->render('success');
    }
}
