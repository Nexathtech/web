<?

use kodi\frontend\assets\AppAsset;
use yii\helpers\Html;

/**
 * The view file for the "order-coupon/success" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\common\models\Order
 * @see \kodi\frontend\controllers\OrderCouponController::actionSuccess()
 */

$this->title = Yii::t('frontend', 'Kodi Order payment success');
?>

<div class="order-thank-page page-regular">
    <div class="otp-words">
        <div class="otp-title"><?= Yii::t('frontend', 'Welcome among us!') ?></div>
        <div class="otp-desc">
            <?= Yii::t('frontend', 'Soon you will receive information about your shipment') ?>
        </div>
    </div>
</div>
