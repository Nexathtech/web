<?php

use kodi\frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * The view file for the "site/apple-wait" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var \kodi\frontend\models\forms\SubscribeForm $subscribeModel
 * @see \kodi\frontend\controllers\SiteController::actionAppleWait()
 */


$this->title = Yii::t('frontend', 'Kodi Plus - Apple waiting list');
$this->registerMetaTag(['content' => Yii::t('frontend', 'The only application that does not require any login to print your photos directly from the social media you prefer. Print an indelible moment or give a special memory making a surprise to your beloved and receive wherever you want. Oh I forgot: NO shipping costs, NO printing costs. Totally FREE.'), 'name' => 'description']);
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/styles/site/downloadapp.css', ['depends' => AppAsset::class]);
?>

<div class="d-app wl">
    <a href="/" class="da-logo"></a>
    <img src="/images/waiting-list-alien.png" alt="Kodi Alien">
</div>

<h1><?= Yii::t('frontend', 'hello! ciao! hola!') ?></h1>
<h4><?= Yii::t('frontend', 'We speak your language') ?></h4>
<div class="wl-desc">
    <?= Yii::t('frontend', 'V"Z38 apologizes for the inconvenience and invites you to enter your email to be updated as soon as KodiPlus will be available for iOS. V"Z38 has an iphone.') ?>
</div>

<div class="wl-subscribe">
    <? $form = ActiveForm::begin(); ?>
    <?= $form->field($subscribeModel, 'email')->textInput([
        'placeholder' => Yii::t('frontend', 'type email'),
        'class' => 'subscribe-email',
    ])->label(false); ?>
    <?= Html::submitButton('Send', ['class' => 'btn text-black']); ?>
    <? $form->end() ?>
</div>

<div class="d-bottom"></div>
