<?php

use kodi\common\enums\Language;
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

$this->title = Yii::t('frontend', 'Kodi Plus - Your memories are Plus');
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
        <p><?= Yii::t('frontend', 'Your memories are Plus.') ?></p>
        <span><?= Yii::t('frontend', 'print 10 photos for free a month with KodiPlus') ?></span>
    </div>
    <div class="people-jump"></div>
    <div class="p-p-heading">
        <p><?= Yii::t('frontend', 'Print your photos'); ?></p>
        <p><?= Yii::t('frontend', 'has become a game:'); ?></p>
        <p><?= Yii::t('frontend', 'with kodiplus only a few clicks are enough.'); ?></p>
        <p><?= Yii::t('frontend', 'Your moments are the most precious thing you have'); ?>,</p>
        <p><?= Yii::t('frontend', 'let them explode in reality.'); ?></p>
        <p><?= Yii::t('frontend', 'Have we already said that it is'); ?></p>
        <p><?= Yii::t('frontend', 'totally free?'); ?></p>
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
                <div class="p-p-title p-p-t-1"><?= Yii::t('frontend', 'direct from{br}instagram', ['br' => '<br>']); ?></div>
                <div class="p-p-line p-p-l-1"></div>
                <div class="p-p-desc p-p-d-1">
                    <?= Yii::t('frontend', 'KodiPlus is the first application which gives you the power to freely print from instagram. Now you can print the photos of the people you love or give them a token of your affection - right from the sofa in your sitting room!'); ?>
                </div>
                <div class="p-p-title p-p-t-2"><?= Yii::t('frontend', 'you look{br}awesome', ['br' => '<br>']); ?></div>
                <div class="p-p-line p-p-l-2"></div>
                <div class="p-p-desc p-p-d-2">
                    <?= Yii::t('frontend', 'Choose the photo and the format that you like best. Do you find yourself alone sometimes, smiling for a selfie? Don’t worry - we do it too. You’re not satisfied with the results? No problem - you can change it in an instant.'); ?>
                </div>
                <div class="p-p-title p-p-t-3"><?= Yii::t('frontend', 'home sweet{br}home', ['br' => '<br>']) ?></div>
                <div class="p-p-line p-p-l-3"></div>
                <div class="p-p-desc p-p-d-3">
                    <?= Yii::t('frontend', 'At home, at the office, at a restaurant, at a wedding: wherever you happen to be, you can now make a polaroid{trademark} without even thinking about it. Now you’ve got something to look forward to in your mail.', ['trademark' => '®*']); ?>
                </div>
            </div>
        </div>
        <div class="moments-matter">
            <div class="m-m-cont">
                <div class="m-m-img"></div>
                <div class="m-m-desc">
                    <?= Yii::t('frontend', 'Memory, backup and cloud...{br}If the mere mention of these words{br}is enough to make you shiver{br}or worry about losing the photos{br}that matter to you, try Kodi.{br}Kodi Station and Kodi Plus{br}will allow you to keep your memories{br}in the best and safest way possible:{br}in your hand.', ['br' => '<br>']); ?>
                </div>
                <div class="m-m-title"><?= Yii::t('frontend', 'moment matters'); ?></div>
            </div>
        </div>
        <div class="colored-lines c-l-2">
            <div class="c-l-yellow"></div>
            <div class="c-l-pink"></div>
            <div class="c-l-blue"></div>
            <div class="c-l-red"></div>
            <div class="c-l-brown-light"></div>
        </div>
        <? if (Yii::$app->language === Language::ENGLISH): ?>
            <div class="app-download" id="download">
                <div class="a-d-description">
                    The Kodi App
                    let’s you curate,
                    download, and
                    even print
                    images from you
                    and your friends’
                    social media
                    accounts.
                </div>
                <div class="iphone-mockup i-m-home"></div>
                <div class="app-checkout">
                    <div class="a-ch-title">Order and download now!</div>
                    <table>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Item description</th>
                            <th>Price</th>
                            <th>Download</th>
                        </tr>
                        <tr>
                            <td><img src="/images/app-thumbnail.png"></td>
                            <td class="a-ch-name">Kodi App <span>ios format</span></td>
                            <td>$0.00</td>
                            <td><a href="#" class="btn disabled" title="Coming soon on App Store">Checkout</a></td>
                        </tr>
                        <tr>
                            <td><img src="/images/app-thumbnail.png"></td>
                            <td class="a-ch-name">Kodi App <span>android format</span></td>
                            <td>$0.00</td>
                            <td><a href="https://goo.gl/gqvrUF" target="_blank" class="btn" title="Coming soon on Play Store">Checkout</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        <? else: ?>
            <div class="app-download">
                <div class="iphone-mockup i-m-home"></div>
                <div class="a-d-desc">
                    <div class="a-d-title">it's already in your hands</div>
                    <a href="#" id="download" class="a-d-ios disabled" title="Coming soon on App Store"></a>
                    <a href="https://goo.gl/gqvrUF" target="_blank" class="a-d-android" title="Download from Play Store"></a>
                </div>
            </div>
        <? endif; ?>
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
        <?= Yii::t('frontend', 'your phone{br}is the key', ['br' => '<br>']); ?>
        <div class="p-k-desc">
            <?= Yii::t('frontend', 'KodiPlus is constantly evolving.{br}Stay up to date to see all the latest service innovations that we’ve got in store for you.', ['br' => '<br>']); ?>
        </div>
    </div>
    <div class="p-p-bottom">
        <div class="b-i-block">
            <div class="b-i-title"><?= Yii::t('frontend', 'promote your brand{br}in few minutes', ['br' => '<br>']) ?></div>
            <?= Yii::t('frontend', 'discover how is easy to reach real people{br}and show how beautiful you are', ['br' => '<br>']); ?>
            <br>
            <a class="btn" href="/brands">kodi ads</a>
        </div>
        <div class="b-i-block">
            <div class="b-i-title"><?= Yii::t('frontend', 'get your shop{br}to the next level', ['br' => '<br>']); ?></div>
            <?= Yii::t('frontend', 'your shop can become a smart shop.{br}Find out how', ['br' => '<br>']); ?>
            <br>
            <a class="btn text-blue" href="/brands#point">kodi point</a>
        </div>
    </div>
</div>
