<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \kodi\common\models\user\User */
/* @var $token string */

$resetLink = 'cc';

?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->profile->name) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
