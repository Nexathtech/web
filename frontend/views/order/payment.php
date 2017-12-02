<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * The view file for the "order/payment" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\common\models\Order
 * @var $price array prices
 * @see \kodi\frontend\controllers\OrderController::actionPayment()
 */

$this->title = Yii::t('frontend', 'Kodi Order payment');

?>

<div class="page-order order-payment page-regular">
    <div class="page-title">
        <a href="/order" class="passive"><?= Yii::t('frontend', 'Order details'); ?></a>
        <div class="title-delimiter"></div>
        <a href="/order/info" class="passive"><?= Yii::t('frontend', 'Information details'); ?></a>
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
                        <a href="/order/info"><?= Yii::t('frontend', 'modify?') ?></a>
                    </div>
                </div>
            </div>
            <div class="o-c-m-sum">
                <div>
                    <?= Yii::t('frontend', 'Kodi station'); ?>
                    <span>$<?= $price['product']; ?></span>
                </div>
                <div>
                    <?= Yii::t('frontend', 'Shipping'); ?>
                    <span>$<?= $price['shipping']; ?></span>
                </div>
                <div>
                    <?= Yii::t('frontend', 'Total order'); ?>
                    <span>$<?= $price['total']; ?></span>
                </div>
            </div>
        </div>
        <div class="o-c-wide">
            <div class="o-p-question"><?= Yii::t('frontend', 'how would you like to pay?'); ?></div>
            <?= Html::beginForm('', 'post', ['class' => 'o-submit-form']); ?>
            <div class="o-payment-check">
                <?= Html::checkbox('payment_bitcoin', false, ['id' => 'payment-bitcoin']); ?>
                <?= Html::label(Yii::t('frontend', 'Bitcoin'), 'payment-bitcoin'); ?>
                <?= Html::checkbox('payment_transferwise', false, ['id' => 'payment-transferwise']); ?>
                <?= Html::label(Yii::t('frontend', 'Wiretransfer'), 'payment-transferwise'); ?>
            </div>
            <?= Html::submitButton(Yii::t('frontend', 'Proceed'), ['class' => 'btn btn-md disabled']); ?>
        </div>
    </div>

    <a class="page-close" href="/order/info"></a>
</div>
