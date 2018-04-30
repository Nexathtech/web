<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Email template for wire transfer order
 *
 * $this yii\web\View
 * @var $data array
 */

$homeUrl = str_replace('api.', '', Url::home(true));
$homeUrl = str_replace('backend.', '', $homeUrl);
?>

<div>
    <h1 class="text-center"><?= Yii::t('frontend', 'Thanks for ordering Kodi station!'); ?></h1>
    <p>
        <?= Yii::t('frontend', 'Below is our bank requisites to proceed with the payment'); ?><br>
        <?= Yii::t('frontend', 'Please provide your Kodi order number in the bank wire comments.'); ?>
    </p>

    <table>
        <tr>
            <th><?= Yii::t('frontend', 'Order number'); ?></th>
            <td>#<?= $data['id']; ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('frontend', 'Order total'); ?></th>
            <td><span class="amount">$<?= number_format($data['total']); ?></span></td>
        </tr>
        <tr>
            <th><?= Yii::t('frontend', 'Beneficiary'); ?></th>
            <td><?= $data['bank_beneficiary']; ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('frontend', 'Account number'); ?></th>
            <td><span class="amount"><?= $data['bank_account_number']; ?></span></td>
        </tr>
        <tr>
            <th><?= Yii::t('frontend', 'SWIFT code'); ?></th>
            <td><span class="amount"><?= $data['bank_swift_code']; ?></span></td>
        </tr>
        <tr>
            <th><?= Yii::t('frontend', 'Bank name'); ?></th>
            <td><span class="amount"><?= $data['bank_name']; ?></span></td>
        </tr>
        <tr>
            <th><?= Yii::t('frontend', 'Bank address'); ?></th>
            <td><span class="amount"><?= $data['bank_address']; ?></span></td>
        </tr>
    </table>
</div>
