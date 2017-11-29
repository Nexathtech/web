<?php

use kodi\frontend\assets\SkrollrAsset;

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\frontend\models\forms\ContactForm content
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */

$this->title = 'Kodi Plus';
$this->params['breadcrumbs'][] = $this->title;

SkrollrAsset::register($this);
// Note, we do not support skrollr on non-desktop devices
$this->registerCssFile('/styles/site/plus.css', [
    'media' => 'only screen and (min-width: 1001px)',
    'data-skrollr-stylesheet' => '',
]);
$this->registerJs("
if (!(/Android|iPhone|iPad|iPod|BlackBerry/i).test(navigator.userAgent || navigator.vendor || window.opera)) {
  var s = skrollr.init({forceHeight: false});
}   
");
?>

<div class="page-plus">
    <div class="colored-lines">
        <div class="c-l-red"></div>
        <div class="c-l-blue"></div>
        <div class="c-l-pink"></div>
        <div class="c-l-yellow"></div>
    </div>
    <div class="p-p-main">
        <div class="p-p-m-cont">
            <div class="iphone-mockup i-m-search"></div>
            <div class="iphone-mockup i-m-preview"></div>
            <div class="iphone-mockup i-m-shipping"></div>
            <div class="p-p-block">
                <div class="p-p-title p-p-t-1">direct from<br>instagram</div>
                <div class="p-p-line p-p-l-1"></div>
                <div class="p-p-desc p-p-d-1">
                    KODI PLUS is the first application which gives you the power to freely print from instagram. Now you can print the photos of the people you love or give them a token of your affection - right from the sofa in your sitting room!
                </div>
                <div class="p-p-title p-p-t-2">you look<br>awesome</div>
                <div class="p-p-line p-p-l-2"></div>
                <div class="p-p-desc p-p-d-2">
                    Choose the photo and the format that you like best. Do you find yourself alone sometimes, smiling for a selfie? Don’t worry - we do it too. You’re not satisfied with the results? No problem - you can change it in an instant.
                </div>
                <div class="p-p-title p-p-t-3">home sweet<br>home</div>
                <div class="p-p-line p-p-l-3"></div>
                <div class="p-p-desc p-p-d-3">
                    At home, at the office, at a restaurant, at a wedding: wherever you happen to be, you can now make a polaroid without even thinking about it. Now you’ve got something to look forward to in your mail.
                </div>
            </div>
        </div>
        <div class="moments-matter">
            <div class="m-m-cont">
                <div class="m-m-img"></div>
                <div class="m-m-desc">
                    Memory, backup and cloud...<br>
                    If the mere mention of these words<br>
                    is enough to make you shiver<br>
                    or worry about losing the photos<br>
                    that matter to you, try Kodi.<br>
                    Kodi Station and Kodi Plus<br>
                    will allow you to keep your memories<br>
                    in the best and safest way possible:<br>
                    in your hand.
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
                download<br>now<br>
                <a href="#" class="a-d-ios" title="Download Kodi on App Store"></a>
                <a href="#" class="a-d-android" title="Download Kodi on Play Store"></a>
            </div>
        </div>
    </div>
    <div class="phone-key">
        your phone<br>is the key
    </div>
    <div class="p-p-bottom">
        <div class="b-i-block">
            Kodi Plus is constantly evolving.<br>
            Stay up to date to see all the latest service innovations that we’ve got in store for you.<br>
            Your phone will be the key to managing the digital kiosk of tomorrow.
        </div>
        <div class="b-i-block">
            <div class="b-i-title">discover the future<br>of printing</div>
            From your phone or a Kodi station, the digital printing revolution with personalized content is a world of infinite possibilities, which you can’t do without.<br>
            <a class="btn" href="/printing">kodi printing</a>
        </div>
        <div class="b-i-block">
            <div class="b-i-title">a digital app for a real<br>kiosk</div>
            With Kodi Plus, you can make payments, find the nearest Kodi station and manage your count. Now you just have to find a Kodi station for yourself to see how this works.<br>
            <a class="btn text-blue" href="/station">kodi station</a>
        </div>
    </div>
</div>
