<?

use kodi\frontend\assets\AppAsset;
use yii\helpers\Html;

/**
 * The view file for the "order/payment" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\common\models\Order
 * @var $bankDetails array
 * @see \kodi\frontend\controllers\OrderController::actionPayment()
 */

$this->title = Yii::t('frontend', 'Kodi Order payment');
?>

<div class="order-thank-page page-regular">
    <div class="page-title">
        <?= Yii::t('frontend', 'Wire Transfer Details'); ?>
    </div>

    <div class="page-content">
        <h1 class="text-center"><?= Yii::t('frontend', 'Thanks for ordering!'); ?></h1>
        <p>
            <?= Yii::t('frontend', 'Below is our bank requisites to proceed with the payment'); ?><br>
            <?= Yii::t('frontend', 'Please provide your Kodi order number in the bank wire comments.'); ?>
        </p>

        <table class="table-order table-striped">
            <tr>
                <th><?= Yii::t('frontend', 'Order number'); ?></th>
                <td>#<?= $model->id; ?></td>
            </tr>
            <tr>
                <th><?= Yii::t('frontend', 'Order total'); ?></th>
                <td><span class="amount">$<?= number_format($model->total); ?></span></td>
            </tr>
            <tr>
                <th><?= Yii::t('frontend', 'Beneficiary'); ?></th>
                <td><?= $bankDetails['bank_beneficiary']; ?></td>
            </tr>
            <tr>
                <th><?= Yii::t('frontend', 'Account number'); ?></th>
                <td><span class="amount"><?= $bankDetails['bank_account_number']; ?></span></td>
            </tr>
            <tr>
                <th><?= Yii::t('frontend', 'SWIFT code'); ?></th>
                <td><span class="amount"><?= $bankDetails['bank_swift_code']; ?></span></td>
            </tr>
            <tr>
                <th><?= Yii::t('frontend', 'Bank name'); ?></th>
                <td><span class="amount"><?= $bankDetails['bank_name']; ?></span></td>
            </tr>
            <tr>
                <th><?= Yii::t('frontend', 'Bank address'); ?></th>
                <td><span class="amount"><?= $bankDetails['bank_address']; ?></span></td>
            </tr>
        </table>

    </div>

    <a class="page-close" href="/order-coupon"></a>
</div>
