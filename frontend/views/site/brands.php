<?php

use kodi\frontend\assets\AppAsset;
use kodi\frontend\assets\SkrollrAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $becomeBrandModel \kodi\frontend\models\forms\BecomeBrandForm
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */


$this->title = Yii::t('frontend', 'Kodi Ads - Play Different');
$this->registerMetaTag(['content' => Yii::t('frontend', 'An innovative and advanced advertisement model, able to reach people in a new and surprising way. Discover all the opportunities to promote your brand easily.'), 'name' => 'description']);
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/styles/site/adsz.css', ['depends' => AppAsset::class]);
$this->registerCssFile('/styles/site/ads-medium.css', [
    'media' => 'only screen and (max-width: 1001px)',
    'data-skrollr-stylesheet' => '',
    'depends' => AppAsset::class
]);
$this->registerCssFile('/styles/site/brands.css', ['depends' => AppAsset::class]);
$this->registerJsFile('/js/adsz.js', ['depends' => [AppAsset::class, SkrollrAsset::class]]);
?>

<div class="brands-top">
    <div class="stamp">
        <div class="stamp-l">
            <div>
                <?= Yii::t('frontend', 'We print') ?> &nbsp;&nbsp;<br>
                <?= Yii::t('frontend', 'Deliver') ?> &nbsp;&nbsp;<br>
                <?= Yii::t('frontend', 'Connect') ?> &nbsp;&nbsp;
            </div>
            <div class="stamp-i stamp-i-3"></div>
            <div class="stamp-i stamp-i-4"></div>
        </div>
        <div class="stamp-r">
            <div class="stamp-i stamp-i-1"></div>
            <div class="stamp-i stamp-i-2"></div>
            <div>
                &nbsp;&nbsp;<?= Yii::t('frontend', 'Your') ?><br>
                &nbsp;&nbsp;<?= Yii::t('frontend', 'ads') ?><br>
                &nbsp;&nbsp;<span><?= Yii::t('frontend', 'to our users') ?></span>
            </div>
        </div>
    </div>
</div>

<div class="brands-intro">
    <div class="bi-title">
        <?= Yii::t('frontend', 'Your advertising{br}becomes real', ['br' => '<br>']) ?>
    </div>
    <div class="bi-desc bi-desc-1">
        <?= Yii::t('frontend', 'Kodiplus users receive 10 photos{br}for free every month{br}We do not print any kind{br}of advertising in the photos', ['br' => '<br>']) ?>
        <div class="bi-square-lines"></div>
    </div>
    <div class="bi-equation">
        <div class="bi-photos"></div>
        <div class="bi-character">+</div>
        <div class="bi-brand"><div class="bi-brand-pic"></div></div>
        <div class="bi-character">=</div>
        <div class="bi-envelope"></div>
    </div>
    <div class="bi-desc bi-desc-2">
        <?= Yii::t('frontend', 'Advertise what you want:{br}a coupon, a new course in the gym, an event,{br}a new product. Or spread your artwork,{br}thanks to your customers or anything else{br}you think can grow your business.', ['br' => '<br>']) ?>
    </div>
</div>

<div class="brands-desc">
    <div class="bd-title"><?= Yii::t('frontend', 'find out how it works') ?></div>
    <div class="bd-containers">
        <div class="bd-left">
            <div class="bd-dots-1"></div>
            <p>
                <?= Yii::t('frontend', 'Download the {KodiPlus} app and switch the account in brand: a simple interface that will allow you to create your message in a few clicks', ['KodiPlus' => Html::a('KodiPlus', '/plus')]) ?>
            </p>
            <div class="bd-dots-3"></div>
            <p>
                <?= Yii::t('frontend', 'Always get a 1: 1 communication, getting the most attention from the customer.{br}Your printed advertising has an entirely different value.', ['br' => '<br>']) ?>
            </p>
        </div>
        <div class="bd-right">
            <div class="bd-dots-2"></div>
            <p>
                <?= Yii::t('frontend', 'With Kodi Ads, you will always reach real people.{br}Reinvent your advertising in a new way according to your needs.', ['br' => '<br>']) ?>
            </p>
            <div class="bd-dots-4"></div>
            <p>
                <?= Yii::t('frontend', '0 risks clickbait, 0 bots, 0 spam.{br}Your advertising will be 100% effective.', ['br' => '<br>']) ?>
            </p>
        </div>
    </div>

    <div class="bd-subscribe">
        <? $form = ActiveForm::begin(); ?>
        <?= $form->field($becomeBrandModel, 'email')->textInput([
            'placeholder' => Yii::t('frontend', 'type in your email'),
            'class' => 'subscribe-email',
        ])->label(false); ?>
        <div class="wrap">
            <?= Html::submitButton(Yii::t('frontend', 'request free trial'), ['class' => 'btn btn-block']); ?>
        </div>
        <? $form->end() ?>
    </div>
</div>

<?= $this->render('_brands_numbers'); ?>

<div class="brands-subscribe" id="member">
    <div class="b-s-title">
        <?= Yii::t('frontend', 'We are ready, you?') ?>
    </div>
    <div class="b-s-desc">
        <?= Yii::t('frontend', 'Change your advertising from today with Kodi Ads.') ?>
    </div>
    <div class="bs-subscribe">
        <? $form = ActiveForm::begin(); ?>
        <?= $form->field($becomeBrandModel, 'email')->textInput([
            'placeholder' => Yii::t('frontend', 'type in your email'),
            'class' => 'subscribe-email',
        ])->label(false); ?>
        <div class="wrap">
            <?= Html::submitButton(Yii::t('frontend', 'request free trial'), ['class' => 'btn btn-block']); ?>
        </div>
        <? $form->end() ?>
    </div>
</div>

<div class="b-i-block">
    <div class="b-i-title">
        <?= Yii::t('frontend', 'Change the rules{br}of your store', ['br' => '<br>']) ?>
    </div>
    <?= Yii::t('frontend', 'add new features and get different communication.') ?>
    <br>
    <a class="btn text-blue" href="/point">kodi point</a>
</div>
<div class="b-i-block">
    <div class="b-i-title">
        <?= Yii::t('frontend', 'Print the photos{br}you love for free', ['br' => '<br>']) ?>
    </div>
    <?= Yii::t('frontend', 'discover kodiplus, the easiest application in the world to print your memories.') ?>
    <br>
    <a class="btn" href="/">kodi plus</a>
</div>
