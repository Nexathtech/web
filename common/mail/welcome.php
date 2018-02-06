<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user \kodi\common\models\user\User */
/* @var $confirmationUrl string Absolute url */

$homeUrl = str_replace('api.', '', Url::to(['/'], true));
?>

<div class="thank-preset" style="margin-top: 50px;text-align: center;">
    <img src="<?= $homeUrl ?>/styles/img/thanks-to-be.png" style="max-width: 100%;">
</div>
<div>
    <p>Hello <?= Html::encode($user->profile->name); ?>,</p>
    <p>Thanks for your registration! In order to activate your account, please follow this link:</p>
    <p>
        <?= Html::a('Activate my account', $confirmationUrl, [
            'style' => 'display: inline-block; padding: 10px 20px; background: #05bc45; color: #fff; text-decoration: none;'
        ]); ?>
    </p>
</div>
