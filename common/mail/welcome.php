<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user \kodi\common\models\user\User */
/* @var $confirmationUrl string Absolute url */

$homeUrl = str_replace('api.', '', Url::to(['/'], true));
?>

<div class="thank-preset" style="padding-top: 20px;background: #aeceed;text-align: center;">
    <a class="logo" href="<?= $homeUrl; ?>" style="display: block; width: 80px; height: 40px; margin: 0 auto 100px; background: url(<?= $homeUrl; ?>styles/img/logo.png); background-size: 100%;"></a>
    <img src="<?= $homeUrl ?>styles/img/english-guard.png" alt="" style="max-width: 100%;">
</div>

<div class="content" style="max-width: 400px;margin: 20px auto 10px;font-family: 'HKNova', 'sans-serif';font-size: 20px;text-align: justify;color: #45433d;">
    <div class="title" style="margin: 40px 0 20px;text-align: center;font-family: 'Alte DIN', sans-serif;font-weight: bold;font-size: 40px;color: #e79b9f;">
        <?= Yii::t('common', 'Just another step') ?>
    </div>

    <?= Yii::t('common', 'It looks grumpy, but our guard McKenny just wants to remind you to press yeah to activate your Kodi account.') ?>

    <?= Html::a('yeah', $confirmationUrl, [
        'style' => 'display: inline-block; margin: 40px auto; padding: 10px 20px; background: #ffce46; color: #fff; text-decoration: none;'
    ]); ?>

    <?= $this->render('layouts/includes/_social_links', ['homeUrl' => $homeUrl]) ?>
</div>
