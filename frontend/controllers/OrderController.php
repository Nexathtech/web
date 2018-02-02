<?php

namespace kodi\frontend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\enums\order\OrderType;
use kodi\common\enums\order\PaymentType;
use kodi\common\enums\order\Status;
use kodi\common\models\Order;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Cookie;

/**
 * Class `OrderController`
 * ======================
 *
 * This controller is responsible for rendering order page.
 */
class OrderController extends Controller
{
    /**
     * Displays order page with info about product.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $productPrice = Yii::$app->settings->get('device_station_cost');
        $orderDetails = Yii::$app->request->cookies->getValue('order', [
            'color' => 'yellow',
            'quantity' => 1,
        ]);

        // If user click pay button
        if ($request->post('tac_agreement') && $request->post('p_agreement')) {
            $color = $request->post('color') ?: 'yellow';
            $quantity = $request->post('quantity') ?: 1;
            $order = ArrayHelper::merge($orderDetails, [
                'color' => $color,
                'quantity' => $quantity,
            ]);

            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'order',
                'value' => $order,
            ]));

            return $this->redirect(['info']);
        }

        return $this->render('index', [
            'price' => $productPrice,
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
        $model->type = OrderType::KIOSK;

        if (!$model->validate()) {
            return $this->redirect(['/order/info']);
        }

        $productCostData = Yii::$app->settings->get(['device_station_cost', 'device_station_shipping_cost']);
        $productCost = $productCostData['device_station_cost'] * $model->quantity;
        $shippingCost = $productCostData['device_station_shipping_cost'];
        $price = [
            'product' => $productCost,
            'shipping' => $shippingCost,
            'total' => $productCost + $shippingCost,
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

        // Handle Bitcoin choice
        if (Yii::$app->request->post('payment_bitcoin')) {

        }

        return $this->render('payment', [
            'model' => $model,
            'price' => $price,
        ]);
    }
}
