<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Email template for photo order status update
 *
 * $this yii\web\View
 * @var $data array
 */

$homeUrl = str_replace('api.', '', Url::to(['/'], true));
?>

<div class="thank-preset" style="padding-top: 20px;background: #e79b9f;text-align: center;">
    <a class="logo" href="<?= $homeUrl; ?>" style="display: block; width: 80px; height: 40px; margin: 0 auto 100px; background: url(<?= $homeUrl; ?>styles/img/logo.png); background-size: 100%;"></a>
    <img src="<?= $homeUrl ?>styles/img/sailor.png" alt="" style="display: block; margin: 0 auto; max-width: 100%;">
</div>

<div class="content" style="max-width: 400px;margin: 20px auto 10px;font-family: 'HKNova', 'sans-serif';font-size: 16px;text-align: justify;color: #3d3d3d;">
    <div class="title" style="margin: 40px 0 20px;text-align: center;font-family: 'Alte DIN', sans-serif;font-weight: bold;font-size: 40px;color: #ffce45;">
        <?= Yii::t('common', 'Is coooooming{br}for you', ['br' => '<br>']) ?>
    </div>

    <?= Yii::t('common', 'Get off the anchor, closed the little bridge, Captain Hernstz\'s ship was spotted in the ocean this morning while at full speed she rushed towards you to deliver you fantastic photos.') ?>
    <br>
    <?= Yii::t('common', '"See you soon!" - Captain Hernst') ?>

    <?= $this->render('layouts/includes/_social_links', ['homeUrl' => $homeUrl]) ?>
</div>
