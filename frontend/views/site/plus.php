<?php

use kodi\frontend\assets\AppAsset;
use kodi\frontend\assets\SkrollrAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\frontend\models\forms\ContactForm content
 * @var $subscribeModel \kodi\frontend\models\forms\SubscribeForm
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */

$this->title = Yii::t('frontend', 'Kodi Plus - Play your memories');
$this->params['breadcrumbs'][] = $this->title;
$metaDesc = Yii::t('frontend', 'The only application that does not require any login to print your photos directly from the social media you prefer. Print an indelible moment or give a special memory making a surprise to your beloved and receive wherever you want. Oh I forgot: NO shipping costs, NO printing costs. Totally FREE.');
$this->registerMetaTag(['content' => $metaDesc, 'name' => 'description']);
$this->registerMetaTag(['content' => $metaDesc, 'property' => 'og:description']);

// Note, we do not support skrollr on non-desktop devices
$this->registerCssFile('/styles/site/plus.css', [
    'media' => 'only screen and (min-width: 1001px)',
    'data-skrollr-stylesheet' => '',
]);
$this->registerJsFile('/js/plus.js', ['depends' => [AppAsset::class, SkrollrAsset::class]]);
?>

<div class="page-plus">
    <div class="p-pl-title">
        <p><?= Yii::t('frontend', 'print photos for free') ?>,</p>
        <p><?= Yii::t('frontend', 'directly from your social media') ?></p>
    </div>
    <div class="people-jump"></div>
    <div class="p-p-heading">
        <p>Print your photos</p>
        <p>has become a game:</p>
        <p>with kodiplus only a few clicks are enough.</p>
        <p>Your moments are the most precious thing you have,</p>
        <p>let them explode in reality.</p>
        <p>Have we already said that it is</p>
        <p>totally free?</p>
    </div>
    <div class="colored-lines">
        <div class="c-l-beige"></div>
        <div class="c-l-red"></div>
        <div class="c-l-blue"></div>
        <div class="c-l-pink"></div>
        <div class="c-l-yellow"></div>
    </div>
    <div class="p-p-main">
        <div class="p-p-m-cont">
            <div class="iphone-mockup i-m-search i-m-major"></div>
            <div class="iphone-mockup i-m-preview i-m-major"></div>
            <div class="iphone-mockup i-m-shipping i-m-major"></div>
            <div class="p-p-block">
                <div class="p-p-title p-p-t-1">direct from<br>instagram</div>
                <div class="p-p-line p-p-l-1"></div>
                <div class="p-p-desc p-p-d-1">
                    <?= Yii::t('frontend', 'KODI PLUS is the first application which gives you the power to freely print from instagram. Now you can print the photos of the people you love or give them a token of your affection - right from the sofa in your sitting room!'); ?>
                </div>
                <div class="p-p-title p-p-t-2">you look<br>awesome</div>
                <div class="p-p-line p-p-l-2"></div>
                <div class="p-p-desc p-p-d-2">
                    <?= Yii::t('frontend', 'Choose the photo and the format that you like best. Do you find yourself alone sometimes, smiling for a selfie? Don’t worry - we do it too. You’re not satisfied with the results? No problem - you can change it in an instant.'); ?>
                </div>
                <div class="p-p-title p-p-t-3">home sweet<br>home</div>
                <div class="p-p-line p-p-l-3"></div>
                <div class="p-p-desc p-p-d-3">
                    <?= Yii::t('frontend', 'At home, at the office, at a restaurant, at a wedding: wherever you happen to be, you can now make a polaroid without even thinking about it. Now you’ve got something to look forward to in your mail.'); ?>
                </div>
            </div>
        </div>
        <div class="moments-matter">
            <div class="m-m-cont">
                <div class="m-m-img"></div>
                <div class="m-m-desc">
                    <?= Yii::t('frontend', 'Memory, backup and cloud...{br}If the mere mention of these words{br}is enough to make you shiver{br}or worry about losing the photos{br}that matter to you, try Kodi.{br}Kodi Station and Kodi Plus{br}will allow you to keep your memories{br}in the best and safest way possible:{br}in your hand.', ['br' => '<br>']); ?>
                </div>
                <div class="m-m-title">moment matters
                </div>
            </div>
        </div>
        <div class="colored-lines c-l-2">
            <div class="c-l-yellow"></div>
            <div class="c-l-pink"></div>
            <div class="c-l-blue"></div>
            <div class="c-l-red"></div>
            <div class="c-l-brown-light"></div>
        </div>
        <div class="app-download">
            <div class="iphone-mockup i-m-home"></div>
            <div class="a-d-desc">
                <div class="a-d-title">it's already in your hands</div>
                <a href="#" class="a-d-ios disabled" title="Coming soon on App Store"></a>
                <a href="#" class="a-d-android disabled" title="Coming soon on Play Store"></a>
            </div>
        </div>
        <div class="subscribe-container">
            <? $form = ActiveForm::begin(); ?>
            <?= $form->field($subscribeModel, 'email')->textInput([
                'placeholder' => Yii::t('frontend', 'Enter your email'),
                'class' => 'subscribe-email',
            ])->label(false); ?>
            <?= Html::submitButton('Get Early Access', ['class' => 'btn btn-block btn-green']); ?>
            <? $form->end() ?>
        </div>
    </div>
    <div class="phone-key">
        your phone<br>is the key
        <div class="p-k-desc">
            <?= Yii::t('frontend', 'Kodi Plus is constantly evolving.{br}Stay up to date to see all the latest service innovations that we’ve got in store for you.', ['br' => '<br>']); ?>
        </div>
    </div>
    <div class="p-p-bottom">
        <div class="b-i-block">
            <div class="b-i-title">promote your brand<br>in few minutes</div>
            <?= Yii::t('frontend', 'discover how is easy to reach real people{br}and show how beautiful you are', ['br' => '<br>']); ?>
            <br>
            <a class="btn" href="#">kodi ads</a>
        </div>
        <div class="b-i-block">
            <div class="b-i-title">get your shop<br>to the next level</div>
            <?= Yii::t('frontend', 'your shop can become a smart shop.{br}Find out how', ['br' => '<br>']); ?>
            <br>
            <a class="btn text-blue" href="#">kodi point</a>
        </div>
    </div>
</div>
