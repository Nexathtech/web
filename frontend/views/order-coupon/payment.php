<?

use kodi\frontend\assets\AppAsset;
use kodi\frontend\assets\StripeAsset;
use yii\helpers\Html;
use yii\web\View;

/**
 * The view file for the "order-coupon/payment" action.
 *
 * @var View $this Current view instance.
 * @var $model \kodi\common\models\Order
 * @var $price array prices
 * @var $stripe array
 * @see \kodi\frontend\controllers\OrderCouponController::actionPayment()
 */

$this->title = Yii::t('frontend', 'Kodi Order payment');

$this->registerCssFile('/styles/order-coupon.css', ['depends' => AppAsset::class]);
$this->registerJsFile('@web/js/order-coupon.js', ['depends' => [StripeAsset::class]]);
$this->registerJs("stripeInit('{$stripe['key']}');");
?>

<div class="page-order order-payment page-regular">
    <div class="page-title">
        <a href="/order-coupon" class="passive"><?= Yii::t('frontend', 'Order details'); ?></a>
        <div class="title-delimiter"></div>
        <a href="/order-coupon/info" class="passive"><?= Yii::t('frontend', 'Information details'); ?></a>
        <div class="title-delimiter"></div>
        <div class="active"><?= Yii::t('frontend', 'Payment'); ?></div>
    </div>

    <div class="page-content order-content">
        <div class="o-c-medium">
            <div class="o-c-m-content">
                <div class="o-p-title"><?= Yii::t('frontend', 'Information details'); ?></div>
                <div class="o-p-details">
                    <?= $model->name ?> <?= $model->surname ?><br>
                    <?= $model->address ?> <?= $model->address2 ?><br>
                    <?= $model->postcode ?>, <?= $model->city ?>, <?= $model->state ?><br>
                    <?= $model->country ?><br>
                    <?= $model->email ?>
                    <div class="order-mark text-right">
                        <a href="/order-coupon/info"><?= Yii::t('frontend', 'modify?') ?></a>
                    </div>
                </div>
            </div>
            <div class="o-c-m-sum">
                <div>
                    <?= Yii::t('frontend', 'Sticker'); ?>
                    <span>&euro;<?= number_format($price['sticker'], 2); ?></span>
                </div>
                <div>
                    <?= Yii::t('frontend', 'Coupon Cards'); ?>
                    <span>&euro;<?= number_format($price['coupon'], 2); ?></span>
                </div>
                <div>
                    <?= Yii::t('frontend', 'Total order'); ?>
                    <span>&euro;<?= number_format($price['total'], 2); ?></span>
                </div>
            </div>
        </div>
        <div class="o-c-wide">
            <div class="o-p-question"><?= Yii::t('frontend', 'how would you like to pay?'); ?></div>
            <?= Html::beginForm('', 'post', ['class' => 'o-submit-form', 'id' => 'payment-form']); ?>
            <div class="o-payment-check">
                <?= Html::checkbox('payment_card', false, ['id' => 'payment-card']); ?>
                <?= Html::label(Yii::t('frontend', 'Credit card'), 'payment-card'); ?>
                <?= Html::checkbox('payment_wiretransfer', false, ['id' => 'payment-wiretransfer']); ?>
                <?= Html::label(Yii::t('frontend', 'Wire Transfer'), 'payment-wiretransfer'); ?>
            </div>
            <!-- Credit card -->
            <div id="stripe-elements">
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
            </div>
            <?= Html::submitButton(Yii::t('frontend', 'Proceed'), ['class' => 'btn btn-md disabled']); ?>
        </div>
    </div>

    <a class="page-close" href="/order-coupon/info"></a>
</div>
