<?php

use kodi\frontend\assets\AppAsset;

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */


$this->title = Yii::t('frontend', 'Kodi Plus - Download app');
$this->registerMetaTag(['content' => Yii::t('frontend', 'The only application that does not require any login to print your photos directly from the social media you prefer. Print an indelible moment or give a special memory making a surprise to your beloved and receive wherever you want. Oh I forgot: NO shipping costs, NO printing costs. Totally FREE.'), 'name' => 'description']);
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/styles/site/downloadapp.css', ['depends' => AppAsset::class]);
?>

<div class="d-app">
    <a href="/" class="da-logo"></a>
    <h1>cosa aspetti?<?//= Yii::t('frontend', 'what are you waiting for?') ?></h1>
    <div class="da-desc">
        ricevi gratuitamente a casa tua 10
        <?//= Yii::t('frontend', 'receive right to your home 10 free') ?><br>
        fantastiche polaroid dei tuoi momenti migliori ogni mese
        <?//= Yii::t('frontend', 'fantastic polaroids of your best moments every month') ?>
    </div>
    <div class="da-picture">
        <img src="/images/da-picture.png" alt="Kodi Polaroid">
    </div>
</div>

<div class="d-buttons">
    <a href="https://goo.gl/gqvrUF" target="_blank" title="Download from Play Store"></a>
    <a href="https://itunes.apple.com/it/app/kodiplus/id1292345331?l=en&mt=8" target="_blank" title="Download from App Store"></a>
</div>

<div class="d-bottom"></div>
