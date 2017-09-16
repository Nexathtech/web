<?php

/* @var $this yii\web\View */
/* @var $user \kodi\common\models\user\User */

?>

<div>
    <p>Hello, <?= $user->profile->name; ?></p>
    <p>Thanks for your registration! In order to activate your account, please follow this link:</p>
    <p><strong><?= $confirmationUrl ?></strong></p>
</div>
