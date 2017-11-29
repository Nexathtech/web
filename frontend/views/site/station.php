<?php

use kodi\frontend\assets\SkrollrAsset;

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\frontend\models\forms\ContactForm content
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */

$this->title = 'Kodi Station';
$this->params['breadcrumbs'][] = $this->title;

SkrollrAsset::register($this);
// Note, we do not support skrollr on non-desktop devices
$this->registerCssFile('/styles/site/station.css', [
    'media' => 'only screen and (min-width: 1001px)',
    'data-skrollr-stylesheet' => '',
]);
$this->registerJs("
if (!(/Android|iPhone|iPad|iPod|BlackBerry/i).test(navigator.userAgent || navigator.vendor || window.opera)) {
  var s = skrollr.init({forceHeight: false});
}

$('.toggle-color').on('click', function() {
  $('.toggle-color').removeClass('active');
  $(this).addClass('active');
  var imageSrc = $(this).data('image');
  $('.c-ch-image img').attr('src', imageSrc);
});    
");
?>

<div class="page-station">
    <div class="s-s-name">
        <a href="#" class="s-s-title">kodi station</a>
    </div>
    <div class="rocket-section">
        <div class="rocket-middle"></div>
        <div class="rocket-curves">
            <div class="curve curve-yellow"><span>the only one rocket</span></div>
            <div class="curve curve-blue"><span>that will never leave you</span></div>
        </div>
    </div>
    <div class="earn-money-title">
        Earn money.
        <div>With style.</div>
    </div>
    <div class="koisks-trio">
        <div class="kiosk-left"></div>
        <div class="kiosk-middle"></div>
        <div class="kiosk-right"></div>
    </div>
    <div class="curve curve-orange">
        <span>everyone</span>
    </div>
    <div class="polaroid-wall"><span>wants</span></div>
    <div class="curve curve-yellow-white"><span>memory</span></div>
    <div class="centered-description align-right">
        We’re photo maniacs, nostalgics<br>
        and artists. We love to<br>
        snap, share and show.<br>
        Our photos make things<br>
        that happen real:<br>
        From now on, you can<br>
        touch the memories.
    </div>
    <div class="portrait-family">
        <div class="portrait-family-uncolored"></div>
        <div class="portrait-family-colored"></div>
    </div>
    <div class="old-title-section">
        <div class="the-old-title">
            the old
            <div>is new</div>
        </div>
        <div class="centered-description">
            Forget waiting for the renaissance<br>
            or spending days in a photo lab.<br>
            Kodi allows you to print your<br>
            memories with extreme simplicity<br>
            in just a few moments,<br>
            straight from your social media
        </div>
        <div class="lines-block"></div>
        <div class="reach-everyone-title">
            Reach everyone
            <div>with your ads</div>
        </div>
        <div class="dreamer-polaroid-block"></div>
        <div class="p-memories-block">
            <div>A completely new space for advertising
            </div>
            with the advantage of a potentially unlimited public:<br>
            who doesn’t want a photo?<br>
            We believe that your moments are unique and personal,<br>
            so we’ll never print on a photo but this makes your advertisement even more important.
        </div>
        <div class="space-for-ads">
            <div>The waiting time for photos</div>
            can be something unique,<br>
            capable of attracting the attention<br>
            of the captive customer.<br>
            Now your company can leverage<br>
            these 30 seconds to send a message<br>
            to the client, based on<br>
            a set of simple guidelines.
        </div>
        <div class="curve curve-orange-2">
            <a class="btn btn-dark" href="#">start today</a>
        </div>
        <div class="design-function">
            <div class="d-f-rectangle">design<br>is<br>function</div>
        </div>
        <div class="figures-block">
            <div class="f-b-row">
                <div class="f-b-left f-b-l-1">
                    <div class="rectangle rectangle-violette"></div>
                    <div class="arch arch-blue-dark"></div>
                    <div class="rectangle rectangle-yellow"></div>
                    <div class="arch arch-red"></div>
                    <div class="f-b-hovered">
                        <div class="f-b-h-cont">
                            <div class="f-b-h-title">A completely versatile solution</div>
                            Designed to fit your needs. You can make Kodi standalone, attach it to the wall, or invent your own solution: You decide.
                        </div>
                    </div>
                </div>
                <div class="f-b-right f-b-r-1">
                    <div class="figures-pillow">
                        <div class="arch arch-blue"></div>
                        <div class="rectangle rectangle-blue-dark"></div>
                        <div class="rectangle rectangle-pink"></div>
                        <div class="arch arch-yellow"></div>
                    </div>
                    <div class="f-b-hovered">
                        <div class="f-b-h-cont">
                            <div class="f-b-h-title">All in 26</div>
                            Innovation and function in just 26 inches. Kodi has been specially designed to attract a wider audience, but at the same time, it can adapt to all environments.
                        </div>
                    </div>
                </div>
            </div>
            <div class="f-b-row">
                <div class="f-b-left f-b-l-2">
                    <div class="rectangle-empty"></div>
                    <div class="f-b-hovered">
                        <div class="f-b-h-cont">
                            <div class="f-b-h-title">Interactive touchscreen</div>
                            The keys to an infinite world: An interactive touchscreen and an amazing design experience to turn even the most boring operations into colorful and fun moments.
                        </div>
                    </div>
                </div>
                <div class="f-b-right f-b-r-2">
                    <div class="rectangle-empty r-e-pink"></div>
                    <div class="rectangle-empty r-e-blue"></div>
                    <div class="f-b-hovered">
                        <div class="f-b-h-cont">
                            <div class="f-b-h-title">Cashless</div>
                            Kodi Station is a lightweight rocker which is easy to manoeuvre: Kodi gives you the possibility to take advantage of all payment types from credit cards to cryptocurrency.
                        </div>
                    </div>
                </div>
            </div>
            <div class="f-b-row">
                <div class="f-b-left f-b-l-3">
                    <div class="arch arch-orange"></div>
                    <div class="arch arch-green"></div>
                    <div class="f-b-hovered">
                        <div class="f-b-h-cont">
                            <div class="f-b-h-title">Services</div>
                            Much more than a simple kiosk, Kodi Station is also a hub for charging your phone and taking advantage of wifi.
                        </div>
                    </div>
                </div>
                <div class="f-b-right f-b-r-3">
                    <div class="arch arch-green-dark a-tiny"></div>
                    <div class="arch arch-black"></div>
                    <div class="arch arch-pink-dark a-big"></div>
                    <div class="f-b-hovered">
                        <div class="f-b-h-cont">
                            <div class="f-b-h-title">Expandable</div>
                            A kiosk which is in constant evolution.
                            We are constantly working on a vast array of accessories for Kodi Station and your photos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="color-choose">
            <div class="c-ch-title">
                Choose<br>your color
                <div class="toggle-color t-g-blue" data-image="/styles/img/rocket-blue.png"></div>
                <div class="toggle-color t-g-yellow active" data-image="/styles/img/rocket-middle.jpg"></div>
                <div class="toggle-color t-g-pink" data-image="/styles/img/rocket-pink.png"></div>
            </div>
            <div class="c-ch-image">
                <img src="/styles/img/rocket-middle.jpg" title="kodi station" alt="kodi station">
            </div>
            <div class="be-designer">
                <div class="b-d-title">Be<br>the designer</div>
                you can customize your<br>
                <u>kodi station</u><br>
                to be just as you want it.<br>
                <a class="btn btn-dark" href="/about#contact">contact</a>
            </div>
        </div>
        <div class="desk-board">
            <div class="rectangle-oblique"></div>
            <div class="print-print">
                print,print<br>
                print,print<br>
                print,print<br>
                print,print<br>
                print,print<br>
                print,print<br>
                <div>this is just<br>the beginning</div>
            </div>
        </div>
        <div class="centered-description desk-text c-d-wide">
            Printing is just the starting point.<br>
            We are working to create a community of graphic artists, illustrators and creatives that can reshape the world of print by ensuring a direct bridge between product creation and the final audience.<br>
            In the not too distant future, we can imagine a girl from Buenos Aires printing a greeting card created in Hong Kong.<br>
            We are always exploring the latest trends and working towards new ways of telling each other’s stories, drawing on storytelling from the past, whether that be from cinema, television, photography or any other media, and bringing it to the latest technology.<br>
            <a class="btn btn-know" href="/printing">know more</a>
        </div>
        <div class="curve curve-yellow-white c-y-w-2">
            <div>Don't<br>call</div>
            <div>it a<br>kiosk</div>
        </div>
        <div class="interaction-title">interaction
            <div>at his best</div>
        </div>
        <div class="figures-weird"></div>
        <div class="centered-description c-d-wide">
            If the world of Kodi could be summed up in a word, it would be interaction.<br>
            We consider it to be the key to the success of our project and at the same time, the focal point for every user experience; but interaction is also, for example, the transversality of our growing creative community with its own audience.<br>
            Every part of the process comes into contact with all others in a simple, continuous and intuitive way.<br>
            This interaction is the result of the needs of the physical world crossing paths with the opportunities offered by digital media.
        </div>
        <div class="square-inside">
            <div class="s-i-col">
                <div class="arch arch-green a-g-2"></div>
                <div class="arch arch-green a-g-2"></div>
                <div class="arch arch-green a-g-2"></div>
            </div>
            <div class="s-i-col">
                <div class="rectangle rectangle-violette-dark"></div>
                <div class="rectangle rectangle-violette-light"></div>
            </div>
            <div class="s-i-col">
                <div class="arch arch-blue-dark"></div>
                <div class="arch arch-orange"></div>
                <div class="rectangle rectangle-orange"></div>
            </div>
            <div class="s-i-title">powerful<br>analytics</div>
            <div class="s-i-desc">
                Control your Kodi Station from anywhere.<br>
                Every owner of a Kodi Station is always<br>
                free to handle their own business with<br>
                the guarantee of remote control access<br>
                to everything that happens at the station,<br>
                watching its interactions<br>
                and checking its metrics.
            </div>
        </div>
        <div class="h-line">
        </div>
        <div class="o-s-platform">
            <div class="o-s-title">open<br>source<br>platform
            </div>
            <div class="o-s-description">
                We are creating a network that can exchange<br>information and opinions on a daily basis, improve<br>according to the feedback of a group or individual,<br>and guarantee all the tools needed to be able to take<br>part in the Kodi project whatever part you want to play.<br>
                This is an intelligent kiosk designed to be upgraded<br>to ensure constant innovation, new services,<br>and to always be one step ahead.
            </div>
            <div class="rectangle-slim r-s-violette"></div>
            <div class="rectangle-slim r-s-pink"></div>
            <div class="rectangle-slim r-s-green"></div>
            <div class="rectangle-slim r-s-yellow"></div>
            <div class="rectangle-slim r-s-blue-light"></div>
            <div class="rectangle-slim r-s-blue"></div>
            <div class="arch arch-tiny arch-yellow"></div>
            <div class="arch arch-tiny arch-violette-light"></div>
            <div class="arch arch-tiny arch-violette"></div>
            <div class="arch arch-tiny arch-green-light"></div>
            <div class="arch arch-tiny arch-orange"></div>
            <div class="arch arch-tiny arch-rosy"></div>
            <div class="arch arch-tiny arch-black"></div>
            <div class="arch arch-tiny arch-blue"></div>
            <div class="arch arch-tiny arch-rosy-light"></div>
            <div class="arch arch-tiny arch-green"></div>
            <div class="arch arch-tiny arch-red"></div>
        </div>
        <div class="curve curve-blue curve-blue-2"></div>
        <div class="take-me">
            <div class="arch arch-yellow"></div>
            we are coming...<br>
            meanwhile, why don't you try<br>
            kodi plus?<br>
            <a class="btn" href="/plus">take me</a>
        </div>
        <div class="update-me">
            <div class="arch arch-rosy"></div>
            do you want to know when<br>
            kodi station will come<br>
            to your city?<br>
            <a class="btn" href="/about#contact">update me</a>
        </div>
    </div>
</div>
