<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$homeUrl = str_replace('api.', '', Url::to(['/'], true));
?>

<div class="thank-preset" style="margin-top: 50px;text-align: center;">
    <img src="<?= $homeUrl ?>/styles/img/thanks-to-be.png" style="max-width: 100%;" alt="">
</div>
<div>
    <p>
        <?= Yii::t('common', 'Thanks for your interest. Master Want-u has an old saying that reads "spaghetti ar sugo are better than ramen". It has nothing to do with it, but we will contact you as soon as possible') ?>
    </p>
</div>
