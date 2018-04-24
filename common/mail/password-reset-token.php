<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user \kodi\common\models\user\User */
/* @var $resetLink string Absolute url */

$homeUrl = str_replace('api.', '', Url::home(true));
?>

<div class="thank-preset" style="padding-top: 20px;background: #e79b9f;text-align: center;">
    <a class="logo" href="<?= $homeUrl; ?>" style="display: block; width: 80px; height: 40px; margin: 0 auto 100px; background: url(<?= $homeUrl; ?>styles/img/logo.png); background-size: 100%;"></a>
    <img src="<?= $homeUrl ?>styles/img/nerd.png" alt="" style="display: block; margin: 0 auto; max-width: 100%;">
</div>

<div class="content" style="max-width: 400px;margin: 20px auto 10px;font-family: 'HKNova', 'sans-serif';font-size: 16px;text-align: justify;color: #3d3d3d;">
    <div class="title" style="margin: 40px 0 20px;text-align: center;font-family: 'Alte DIN', sans-serif;font-weight: bold;font-size: 40px;color: #aeceed;">
        <?= Yii::t('common', 'No, is not a dejà-vu') ?>
    </div>

    <?= Yii::t('common', 'Only 5 people in the world can remember their passwords. Do not despair, not even Culton remembers his, but he can be useful to recover yours.') ?>

    <?= Html::a('reset', $resetLink, [
        'style' => 'display: block; max-width: 200px; margin: 30px auto 0; padding: 10px 0; background: #ffce46; text-align: center; font-size: 22px; color: #fff; text-decoration: none;'
    ]); ?>

    <?= $this->render('layouts/includes/_social_links', ['homeUrl' => $homeUrl]) ?>
</div>
