<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Email template for photo order
 *
 * $this yii\web\View
 * @var $data array
 */

$homeUrl = str_replace('api.', '', Url::home(true));
?>

<div class="thank-preset" style="padding-top: 20px;background: #ffce46;text-align: center;">
    <a class="logo" href="<?= $homeUrl; ?>" style="display: block; width: 80px; height: 40px; margin: 0 auto 100px; background: url(<?= $homeUrl; ?>styles/img/logo.png); background-size: 100%;"></a>
    <img src="<?= $homeUrl ?>styles/img/genie.png" alt="" style="display: block; margin: 0 auto; max-width: 100%;">
</div>

<div class="content" style="max-width: 400px;margin: 20px auto 10px;font-family: 'HKNova', 'sans-serif';font-size: 16px;text-align: justify;color: #3d3d3d;">
    <div class="title" style="margin: 40px 0 20px;text-align: center;font-family: 'Alte DIN', sans-serif;font-weight: bold;font-size: 40px;color: #3d1f72;">
        <?= Yii::t('common', 'Your wish is our priority') ?>
    </div>

    <?= Yii::t('common', 'Wow! Your order is ... is ... it\'s awesome! Papanou has just reported your wish to us, and we are already working to make it better than you think. Relax, go out for a walk, we\'ll take care of it now. Soon you will receive the Kodi superpack.') ?>
    <br>
    <?= Yii::t('common', 'Thank you!') ?>

    <?= $this->render('layouts/includes/_social_links', ['homeUrl' => $homeUrl]) ?>
</div>
