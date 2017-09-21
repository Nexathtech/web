<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \kodi\common\models\user\User */
/* @var $confirmationUrl string Absolute url */

?>

<div>
    <p>Hello <?= Html::encode($user->profile->name); ?>,</p>
    <p>Thanks for your registration! In order to activate your account, please follow this link:</p>
    <p><strong><?= Html::a(Html::encode($confirmationUrl), $confirmationUrl); ?></strong></p>
</div>
