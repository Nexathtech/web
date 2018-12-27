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
    <h1>cosa aspetti?</h1>
    <div class="da-desc">
        ricevi gratuitamente a casa tua 9<br>
        fantastiche polaroid dei tuoi momenti migliori
    </div>
    <div class="da-picture">
        <img src="/images/da-picture.png" alt="Kodi Polaroid">
    </div>
</div>

<div class="d-buttons">
    <a href="https://goo.gl/gqvrUF" target="_blank" title="Download from Play Store"></a>
    <a href="#" title="Download from App Store"></a>
</div>

<div class="d-bottom"></div>
