<?php

use kodi\frontend\assets\AppAsset;
use yii\helpers\Html;

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */


$this->title = Yii::t('frontend', 'Kodi Point - Play Different');
$this->registerMetaTag(['content' => Yii::t('frontend', 'An innovative and advanced advertisement model, able to reach people in a new and surprising way. Discover all the opportunities to promote your brand easily.'), 'name' => 'description']);
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/styles/site/point.css', ['depends' => AppAsset::class]);
$this->registerJsFile('/js/point.js', ['depends' => [AppAsset::class]]);
?>

<div class="point-bookmark-q">
    <div class="pbq-t1"><?= Yii::t('frontend', 'Did you receive our bookmark?') ?></div>
    <div class="pbq-t2"><?= Yii::t('frontend', 'We were waiting for you!') ?></div>
    <div class="pbq-checks">
        <span class="pbq-check" data-state="1"><?= Yii::t('frontend', 'yes') ?></span>
        <span class="pbq-check" data-state="0"><?= Yii::t('frontend', 'no') ?></span>
    </div>
    <div class="pbq-desc">
        <?= Yii::t('frontend', 'Your store has been selected to become a Kodi Point.') ?>
        <br>
        <?= Yii::t('frontend', 'Get our coupon cards and complete the upgrade!') ?>
    </div>
    <a href="/order-coupon" class="btn text-black"><?= Yii::t('frontend', 'get coupon card') ?></a>
</div>

<div class="point-men">
    <div class="point-men-cont">
        <div class="p-m-title">
            <?= Yii::t('frontend', 'Supereasy-{br}yyyyyyyyyy-{br}yy.', ['br' => '<br>']) ?>
        </div>
        <div class="p-m-desc">
            <?= Yii::t('frontend', 'Do you have a shop? A restaurant? A business of any kind?') ?><br>
            <?= Yii::t('frontend', 'Then you\'re in the right place! Kodi Point is the solution for you.') ?><br>
            <?= Yii::t('frontend', 'Become part of a growing community and discover new features reserved for members.') ?>
        </div>
    </div>
</div>

<div class="point-desc">
    <div class="pd-find">
        <div class="pd-find-title"><?= Yii::t('frontend', 'find how') ?></div>
        <div class="pd-row">
            <div class="pd-find-l pd-find-l-1">
                <img src="/images/specialsticker.png">
            </div>
            <div class="pd-find-r pd-find-r-1">
                <div class="pd-title"><?= Yii::t('frontend', 'Special sticker') ?></div>
                <div class="pd-desc">
                    <?= Yii::t('frontend', 'A real Kodi Point needs a special sticker') ?><br>
                    <?= Yii::t('frontend', 'Position the sticker where you want and tell everyone quickly that you are an official partner of Kodi.') ?><br>
                    <span><?= Yii::t('frontend', 'Request it now, it\'s free!') ?></span>
                </div>
                <a href="/order-coupon" class="btn pd-btn text-black"><?= Yii::t('frontend', 'request now') ?></a>
            </div>
        </div>
        <div class="pd-row">
            <div class="pd-find-l pd-find-l-2">
                <div class="pd-title">Coupon cards</div>
                <div class="pd-desc">
                    <?= Yii::t('frontend', 'And if printing was a game?') ?><br>
                    <?= Yii::t('frontend', 'With our coupon cards, you offer your customers the ability to print extra photos with the {KodiPlus} application in a free way.', ['KodiPlus' => Html::a('KodiPlus', '/')]) ?><br>
                    <?= Yii::t('frontend', 'KodiPlus users will receive push notifications having the possibility to know your store and get something unique.') ?><br>
                    <span><?= Yii::t('frontend', 'The more you print, the more it works.') ?></span><br>
                    <?= Yii::t('frontend', 'Do not forget about the {KodiAds} service.', ['KodiAds' => Html::a('Kodi Ads', '/brands')]) ?>
                </div>
                <a href="/order-coupon" class="btn pd-btn text-black"><?= Yii::t('frontend', 'request now') ?></a>
            </div>
            <div class="pd-find-r pd-find-r-2">
                <img src="/images/couponcards.png">
            </div>
        </div>
    </div>
</div>

<div class="point-figures">
    <div class="pf-desc pf-desc-1">
        <div class="pfd-text">
            <?= Yii::t('frontend', 'Thanks to geolocation, KodiPlus users will be able to receive notifications when they are near your business.') ?>
        </div>
        <div class="pf-figure"></div>
    </div>
    <div class="pf-desc pf-desc-2">
        <div class="pf-figure"></div>
        <div class="pfd-text">
            <?= Yii::t('frontend', 'Become part of a continually evolving network with high goals. Your shop has no boundaries.') ?>
        </div>
    </div>
    <div class="pf-desc pf-desc-3">
        <div class="pfd-text">
            <?= Yii::t('frontend', 'Create a recognizable meeting place for users from anywhere in the world. Every KodiPlus user will know that your store is the right place.') ?>
        </div>
        <div class="pf-figure">
            <span class="pff-circle pff-circle-1"></span>
            <span class="pff-circle pff-circle-2"></span>
        </div>
    </div>
    <div class="pf-desc pf-desc-4">
        <div class="pf-figure"></div>
        <div class="pfd-text">
            <?= Yii::t('frontend', 'This is just the beginning!') ?><br>
            <?= Yii::t('frontend', 'Become a Kodi Point today to grow with us and follow all Kodi projects in the pipeline.') ?><br>
            <?= Yii::t('frontend', 'Do not miss this opportunity.') ?>

        </div>
    </div>
</div>

<div class="point-order">
    <div class="p-o-title"><?= Yii::t('frontend', 'What are you waiting for?') ?></div>
    <div class="p-o-desc">
        <?= Yii::t('frontend', 'Choose the plan you prefer and become a Kodi Point in a few clicks.') ?>
    </div>
    <a href="/order-coupon" class="btn"><?= Yii::t('frontend', 'become a kodi point') ?></a>
</div>

<div class="b-i-block">
    <div class="b-i-title">
        <?= Yii::t('frontend', 'Promote your brand{br}in a few moments', ['br' => '<br>']) ?>
    </div>
    <?= Yii::t('frontend', 'find out how to reach real{br}users in a simple way.', ['br' => '<br>']) ?>
    <br>
    <a class="btn text-blue" href="/brands">kodi ads</a>
</div>

<div class="b-i-block">
    <div class="b-i-title">
        <?= Yii::t('frontend', 'Print the photos{br}you love for free', ['br' => '<br>']) ?>
    </div>
    <?= Yii::t('frontend', 'discover kodiplus, the easiest application in the world to print your memories.') ?>
    <br>
    <a class="btn" href="/">kodi plus</a>
</div>
