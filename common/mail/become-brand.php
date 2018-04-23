<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$homeUrl = str_replace('api.', '', Url::to(['/'], true));
?>

<div class="thank-preset" style="padding-top: 20px;background: #412774;text-align: center;">
    <a class="logo" href="<?= $homeUrl; ?>" style="display: block; width: 80px; height: 40px; margin: 0 auto 100px; background: url(<?= $homeUrl; ?>styles/img/logo.png); background-size: 100%;"></a>
    <img src="<?= $homeUrl ?>styles/img/maestro.png" alt="" style="max-width: 100%;margin-bottom: -25px;">
</div>

<div class="content" style="max-width: 400px;margin: 20px auto 10px;font-family: 'HKNova', 'sans-serif';font-size: 16px;text-align: justify;color: #45433d;">
    <div class="title" style="margin: 40px 0 20px;text-align: center;font-family: 'Alte DIN', sans-serif;font-weight: bold;font-size: 40px;color: #e79b9f;">
        <?= Yii::t('common', 'Your sun{br}will shine', ['br' => '<br>']) ?>
    </div>

    <?= Yii::t('common', 'Thanks for your interest. Master Want-u has an old saying that reads "spaghetti ar sugo are better than ramen". It has nothing to do with it, but we will contact you as soon as possible.') ?>

    <?= $this->render('layouts/includes/_social_links', ['homeUrl' => $homeUrl]) ?>
</div>
