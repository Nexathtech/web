<?php
use kodi\frontend\assets\AppAsset;
use kodi\frontend\assets\SkrollrAsset;

/**
 * The view file for the "site/index" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @see \kodi\frontend\controllers\SiteController::actionIndex()
 */

$this->title = 'Kodi';

$this->registerJsFile('@web/js/site/index.js', ['depends' => [SkrollrAsset::class, AppAsset::class]]);
$this->registerCss(".footer {position: relative; top: 17800px;}");
?>

<div class="page-home">
    <div class="section-main" id="section-main" data-0="position: fixed; top: 0%; width: 100%;" data-640="top: -100%;">
        <div class="s-m-content">
            <video id="video1" preload="auto" autoplay="" muted="" playsinline="" webkit-playsinline="">
                <source src="styles/video/kodicomingsoon-h264.mp4" type="video/mp4">
                <div class="section-main-text"></div>
            </video>
        </div>
        <div class="s-m-waves"></div>
    </div>
    <!-- Station section -->
    <div class="section-station" id="section-station" data-0="position: fixed; top: 100%; width: 100%; margin-top: 50px;" data-640="top: 0%; margin-top: 20px;" data-15100="" data-15200="z-index: 1;" data-15300="z-index: 0;" data-17200="" data-17400="top: -50%;">
        <div class="s-s-name" data-0="top: 0%;" data-3600="" data-4000="top: -50%;">
            <a href="/station" class="s-s-title">kodi station</a>
            <a href="/station" class="btn btn-full-width btn-simple">pre-order</a>
        </div>
        <div class="station-figures" data-3000="transform: rotate(0deg) scale(1);" data-3200="transform: rotate(-90deg) scale(1.4);" data-3400="transform: rotate(-180deg) scale(1);">
            <div class="arch arch-yellow" data-0="top: 250px; margin-left: -168px;" data-640="" data-800="top: 50px; margin-left: -258px;" data-2200="" data-2400="margin-left: -98px; top: 140px;" data-3600="transform: rotate(0deg);" data-3800="margin-left: 253px; top: 55px; transform: rotate(90deg);" data-4800="" data-4900="transform: rotate(180deg);" data-6400="" data-6500="margin-left: 133px;" data-6700="" data-6900="top: 275px;" data-9100="" data-9200="top: 425px; margin-left: 283px;" data-9950="" data-10100="top: 175px; margin-left: 133px;" data-11000="" data-11200="top: 75px;">
            </div>
            <div class="rectangle rectangle-purple" data-0="top: 250px; margin-left: 10px; display: block; background: rgb(25,86,128);" data-640="" data-800="top: 50px; margin-left: 100px;" data-1199="" data-1200="background: rgb(255,255,255);" data-1399="" data-1400="background: rgb(25,86,128);" data-2200="" data-2400="margin-left: -70px; top: 240px;" data-3600="transform: rotate(0deg);" data-3800="margin-left: 50px; top: 55px; transform: rotate(90deg);" data-5200="" data-5300="transform: rotate(180deg);" data-6400="" data-6500="margin-left: 0px;" data-6700="" data-6900="top: 275px;" data-8300="" data-8400="top: 165px;" data-9100="" data-9200="top: 25px; margin-left: -300px;" data-9950="" data-10100="top: 175px; margin-left: -160px;" data-11000="" data-11200="top: 315px;" data-16700="" data-16800="top: 195px;">
            </div>
            <div class="rectangle rectangle-pink" data-0="top: 350px; margin-left: -140px; display: block; background: rgb(231,157,161);" data-640="" data-800="top: 540px; margin-left: -230px;" data-999="" data-1000="background: rgb(255,255,255);" data-1599="" data-1600="background: rgb(231,157,161);" data-2200="" data-2400="margin-left: -70px; top: 340px;" data-3600="transform: rotate(0deg);" data-3800="margin-left: -205px; top: 55px; transform: rotate(90deg);" data-5600="" data-5700="transform: rotate(180deg);" data-6400="" data-6500="margin-left: -155px;" data-6700="" data-6900="top: 385px;" data-7100="margin-left: 0px;" data-9100="" data-9200="top: 535px; margin-left: 150px;" data-9950="" data-10100="top: 175px; margin-left: 0px;" data-11000="" data-11200="top: 195px;" data-16000="" data-16100="top: 315px;" data-16700="" data-16800="top: 435px;">
            </div>
            <div class="arch arch-blue" data-0="top: 350px; margin-left: -18px; display: block;" data-640="" data-800="top: 540px; margin-left: 72px;" data-2200="" data-2400="margin-left: -98px; top: 440px;" data-3600="transform: rotate(180deg);" data-3800="margin-left: -483px; top: 55px; transform: rotate(270deg);" data-6000="" data-6100="transform: rotate(360deg);" data-6400="" data-6500="margin-left: -342px;" data-6700="" data-6900="top: 385px;" data-7100="margin-left: -187px;" data-8300="" data-8400="top: 275px;" data-9100="" data-9200="top: 135px; margin-left: -487px;" data-9950="" data-10100="top: 175px; margin-left: -347px;" data-11000="" data-11200="top: 435px;" data-16700="" data-16800="top: 315px;">
            </div>
            <!-- Additional figures -->
            <div data-0="transform: rotate(180deg); width: 100%; height: 670px;">
                <div class="rectangle rectangle-green" data-0="left: -50%; margin-left: 20px;" data-15100="" data-15300="left: 50%;" data-16700="" data-16800="margin-left: 180px;">
                </div>
                <div class="rectangle rectangle-rosy" data-0="margin-left: 20px; left: 150%;" data-15150="" data-15350="left: 50%;" data-16050="" data-16150="margin-left: -300px;">
                </div>
                <div class="rectangle rectangle-red" data-0="margin-left: 180px; left: 150%;" data-15200="" data-15400="left: 50%;" data-16050="" data-16150="margin-left: -140px;">
                </div>
                <div class="rectangle rectangle-green-light" data-0="left: 150%;" data-15050="" data-15250="left: 50%;">
                </div>
                <div class="rectangle rectangle-blue" data-0="left: 150%;" data-15100="" data-15300="left: 50%;">
                </div>
                <div class="arch arch-black" data-0="left: -50%; margin-left: -170px;" data-15150="" data-15350="left: 50%;" data-16700="" data-16800="margin-left: -10px;">
                </div>
                <div class="arch arch-yellow-2" data-0="left: -50%;" data-15200="" data-15400="left: 50%;">
                </div>
                <div class="arch arch-violette" data-0="top: 380px; left: -50%;" data-15180="" data-15350="left: 50%;" data-16000="" data-16100="top: 260px;">
                </div>
                <div class="arch arch-brown" data-0="left: 150%; top: 260px;" data-15100="" data-15300="left: 50%;" data-16700="" data-16800="top: 380px;">
                </div>
                <div class="arch arch-blue-dark" data-0="left: 150%;" data-15250="" data-15450="left: 50%;">
                </div>
            </div>
            <!-- Kiosks -->
            <div class="station-kiosks" data-0="transform: scale(1);" data-4500="transform: scale(1);" data-5000="transform: scale(0.5);">
                <div class="kiosk-pink" data-0="display: none;" data-1600="display: block;" data-2200="display: none;">
                </div>
                <div class="kiosk-blue" data-0="display: none;" data-1400="display: block;" data-2200="display: none;">
                </div>
                <div class="kiosk-yellow" data-0="display: none;" data-1200="display: block;" data-2200="display: none;">
                </div>
            </div>
        </div>
        <div class="s-s-motto" data-0="right: -50%;" data-600="" data-800="right: 0%;" data-2400="" data-2600="right: -50%;">
            <div class="s-s-motto-cont">
                <div class="s-s-motto-1">unique design
                </div>
                <div class="s-s-motto-2">better experience
                </div>
            </div>
        </div>
        <div class="s-s-desc s-s-desc-1" data-0="left: -50%;" data-2600="" data-2800="left: 0%;" data-3000="" data-3200="left: -50%;">
            An open source platform,<br>
            impactful design<br>
            and the highest levels<br>
            of user experience<br>
            are the ingredients<br>
            of interactive<br>
            digital kiosks.
        </div>
        <div class="s-s-desc s-s-desc-2" data-0="right: -50%;" data-2600="" data-2800="right: 0%;" data-3000="" data-3200="right: -50%;">
            Kodi has<br>
            a printer,<br>
            a touchscreen<br>
            <div>and a world
            </div>
            <div class="s-s-desc-big">full of ideas
            </div>
        </div>
        <div class="s-s-desc s-s-desc-3" data-0="left: -50%;" data-3200="" data-3400="left: 0%;" data-3600="" data-3800="left: -50%;">
            This bridge between the<br>
            digital world<br>
            and reality will provide a<br>
            <strong>new way</strong><br>
            to use your daily applications
        </div>
        <div class="s-s-desc s-s-desc-4" data-0="right: -50%;" data-3200="" data-3400="right: 0%;" data-3600="" data-3800="right: -50%;">
            The possibility to print<br>
            in various formats<br>
            in just a few minutes,<br>
            new functionality in an app you’ll love<br>
            and new ways to earn:<br>
            Whether you’re in business or a customer,<br>
            discover why Kodi is something<br>
            you’ve never seen before.<br>
            All that’s left is for you<br>
            to decide<br>
            which aspect you love the most.<br>
        </div>
    </div>
    <!-- Printing section -->
    <div class="section-printing" id="section-printing" data-0="position: fixed; top: 100%; width: 100%; margin-top: 20px;" data-3600="" data-4000="top: 0%;" data-6700="" data-6900="top: -100%;">
        <div class="s-s-name s-p-name">
            <a href="/printing" class="s-s-title s-p-title">kodi printing</a>
            <a href="/printing" class="btn btn-full-width btn-simple">explore</a>
        </div>
        <div class="s-p-content">
            <img class="children" src="styles/img/children.jpg" data-4000="transform: scale(0) rotate(0deg); opacity:0;" data-4400="transform: scale(1) rotate(1080deg); opacity:1;" data-4900="" data-5000="opacity: 0;">
        </div>
        <div class="s-p-content s-p-content-2" data-0="border-color: rgb(43,42,41); opacity: 0;" data-4900="" data-5000="opacity: 1;" data-5300="" data-5400="opacity: 0;" data-5700="border-color: rgb(255,207,70);" data-5800="opacity: 1;" data-6100="" data-6200="border-color: rgb(255,255,255);" data-6600="transform: rotate(0deg); transform-origin: 0 0;" data-6800="transform: rotate(-90deg); opacity: 0;">
            <img class="children" src="styles/img/children.jpg">
        </div>
        <div class="s-p-content s-p-content-3" data-0="opacity: 0;" data-5300="" data-5400="opacity: 1;" data-5700="" data-5800="opacity: 0;">
            <img class="children" src="styles/img/children.jpg">
        </div>
        <div class="s-p-desc s-p-desc-1" data-0="left: -50%;" data-4400="" data-4600="left: 5%;" data-4800="" data-5000="left: -50%;">
            Kodi helps you bring<br>
            your memories to life<br>
            by letting you easily<br>
            print real-life photos<br>
            from your social<br>
            media accounts.<br>
            <strong>any place,<br>any time</strong>
        </div>
        <div class="s-p-desc s-p-desc-2" data-0="right: -50%;" data-4400="" data-4600="right: 0%;" data-4800="" data-5000="right: -50%;">
            Your memories<br>
            in your hands<br>
            in few minutes
        </div>
        <div class="s-p-desc s-p-desc-1" data-0="left: -50%;" data-4900="" data-5100="left: 5%;" data-5500="" data-5700="left: -50%;">
            Your memories<br>
            are yours to hold forever.<br>
            With Kodi<br>
            you can always<br>
            choose the format<br>
            you prefer<br>
            and the color<br>
            you love
        </div>
        <div class="s-p-desc s-p-desc-2" data-0="right: -50%;" data-4900="" data-5100="right: 0%;" data-5500="" data-5700="right: -50%;">
            Your polaroid<br>
            your way
        </div>
        <div class="s-p-desc s-p-desc-1" data-0="left: -50%;" data-5600="" data-5800="left: 5%;" data-6400="" data-6500="left: -50%;">
            The world of print in a whole new dimension.<br>
            a wide selection of the best works<br>
            from the creative community,<br>
            allow them to personalize their content.<br>
            Find out more by clicking Explore<br>
            and see<br>
            how to give a new look to your photos.
        </div>
        <div class="s-p-desc s-p-desc-2" data-0="right: -50%;" data-5600="" data-5800="right: 0%;" data-6400="" data-6500="right: -50%;">
            Printing
        </div>
    </div>
    <!-- Plus section -->
    <div class="section-plus" id="section-plus" data-0="position: fixed; top: 100%; width: 100%; margin-top: 20px;" data-6700="" data-6900="top: 0%;" data-11000="" data-11400="top: -100%;">
        <div class="s-s-name s-pl-name">
            <a href="/plus" class="s-s-title s-pl-title">kodi <span>plus</span></a>
            <a href="/plus" class="btn btn-full-width btn-simple">get the app</a>
        </div>
        <div class="s-pl-content">
            <div class="s-pl-motto s-pl-motto-1" data-0="left: 10px; opacity: 0;" data-7200="" data-7300="left: 0px; opacity: 1;" data-8000="" data-8100="left: 10px; opacity: 0;">
                your<br>polaroid
            </div>
            <div class="s-pl-motto s-pl-motto-2" data-0="right: 10px; opacity: 0;" data-7400="" data-7500="right: 0px; opacity: 1;" data-7700="" data-7800="right: 10px; opacity: 0;">
                wherever<br>you are
            </div>
            <div class="s-pl-motto s-pl-motto-3" data-0="top: 90px; opacity: 0;" data-8600="" data-8700="top: 100px; opacity: 1;" data-8900="" data-9000="top: 90px; opacity: 0;">
                all in<br>one
            </div>
            <div class="s-pl-motto s-pl-motto-4" data-0="top: 165px; opacity: 0;" data-8600="" data-8700="top: 155px; opacity: 1;" data-8900="" data-9000="top: 165px; opacity: 0;">
                simple<br>app
            </div>
        </div>
        <div class="img-iphone" data-0="margin-left: -80px; opacity: 0;" data-9100="" data-9200="margin-left: -90px; opacity: 1;" data-9400="" data-9500="opacity: 0;">
        </div>
        <div class="img-polaroid" data-0="opacity: 0;" data-9400="" data-9500="opacity: 1;" data-9800="transform: rotate(0deg); transform-origin: 0 0;" data-10000="transform: rotate(-90deg); opacity: 0;">
        </div>
        <div class="s-pl-desc s-pl-desc-1" data-0="margin-left: -10px; opacity: 0;" data-9200="" data-9300="margin-left: 0px; opacity: 1;" data-9450="" data-9550="margin-left: -10px; opacity: 0;">
            Imagine having all the functionality<br>
            of a Kodi station right in your hand.<br>
            Kodi Plus is the application<br>
            which allows you to receive<br>
            your favorite images<br>
            from your smartphone in just a few seconds,<br>
            wherever you are.
        </div>
        <div class="s-pl-desc s-pl-desc-2" data-0="margin-right: -10px; opacity: 0;" data-9200="" data-9300="margin-right: 0px; opacity: 1;" data-9450="" data-9550="margin-right: -10px; opacity: 0;">
            your polaroid<br>your way
        </div>
        <div class="s-pl-desc s-pl-desc-1" data-0="margin-left: -10px; opacity: 0;" data-9450="" data-9550="margin-left: 0px; opacity: 1;" data-9700="" data-9800="margin-left: -10px; opacity: 0;">
            Download the application and print<br>
            your moments - Kodi makes your photos a reality.<br>
            From the screen of your smartphone<br>
            direct to your home: it’s really fast.<br>
            You can take a new photo, choose one from your<br>
            or ANY Instagram account, or upload from your gallery.<br>
            Millions of images are all ready for you,<br>
            waiting to be printed. Kodi Plus is the key<br>
            to opening new possibilities which you never knew existed.
        </div>
        <div class="s-pl-desc s-pl-desc-2" data-0="margin-right: -10px; opacity: 0;" data-9450="" data-9550="margin-right: 0px; opacity: 1;" data-9700="" data-9800="margin-right: -10px; opacity: 0;">
            simple, fast<br>and fun
        </div>
        <div class="s-pl-caption" data-0="margin-top: -170px; opacity: 0;" data-10200="" data-10300="margin-top: -160px; opacity: 1;" data-10600="" data-10700="margin-top: -170px; opacity: 0;">directly to your home
        </div>
        <div class="img-shipping-car" data-0="left: -50%; opacity: 0;" data-10300="" data-10500="left: 50%; opacity: 1;" data-10800="" data-11000="left: 150%; opacity: 0;">
        </div>
    </div>
    <!-- Koders section -->
    <div class="section-koders" id="section-koders" data-0="position: fixed; top: 100%; width: 100%; margin-top: 20px;" data-11000="" data-11400="top: 0%;" data-17200="" data-17400="top: -50%;">
        <div class="s-s-name s-k-name">
            <a href="/koders" class="s-s-title s-k-title">koders</a>
        </div>
        <div class="s-k-when" data-0="left: -50%;" data-11400="" data-11500="left: 0%;" data-15000="" data-15100="left: -50%;">
            when i’ll<br>
            grow up<br>
            i’ll become:
        </div>
        <div class="s-k-when-answer" data-0="right: -50%;" data-11400="" data-11500="right: 0%;" data-15000="" data-15100="right: -50%;">
		<span data-0="right: -100%" data-11600="" data-11700="right: 0%;">singer
		<i data-0="width: 0%;" data-11800="" data-11850="width: 100%;"></i>
		</span><br>
            <span data-0="right: -100%" data-12000="" data-12100="right: 0%;">astronaut
		<i data-0="width: 0%;" data-12200="" data-12250="width: 100%;"></i></span><br>
            <span data-0="right: -100%" data-12400="" data-12500="right: 0%;">football player
		<i data-0="width: 0%;" data-12600="" data-12650="width: 100%;"></i></span><br>
            <span data-0="right: -100%" data-12800="" data-12900="right: 0%;">killer
		<i data-0="width: 0%;" data-13000="" data-13050="width: 100%;"></i></span><br>
            <span data-0="right: -100%" data-13200="" data-13300="right: 0%;">scientist
		<i data-0="width: 0%;" data-13400="" data-13450="width: 100%;"></i></span><br>
            <span data-0="right: -100%" data-13600="" data-13700="right: 0%;">indiana jones
		<i data-0="width: 0%;" data-13800="" data-13850="width: 100%;"></i></span><br>
            <span data-0="right: -100%" data-14000="" data-14100="right: 0%;">eskimo
		<i data-0="width: 0%;" data-14200="" data-14250="width: 100%;"></i></span><br>
            <span data-0="right: -100%" data-14600="" data-14700="right: 0%;">koder</span>
        </div>
        <div class="s-k-caption" data-0="margin-left: -310px; opacity: 0;" data-15500="" data-15600="margin-left: -300px; opacity: 1;" data-15800="" data-15900="margin-left: -310px; opacity: 0;">the newest community
        </div>
        <div class="s-k-caption s-k-caption-2" data-0="margin-left: 30px; opacity: 0;" data-16200="" data-16300="margin-left: 20px; opacity: 1;" data-16500="" data-16600="margin-left: 30px; opacity: 0;">young. dynamic. cool
        </div>
        <div class="s-k-button" data-0="margin-top: -10px; opacity: 0;" data-16900="" data-17000="margin-top: 0px; opacity: 1;">
            <a class="btn btn-full-width" href="/koders">apply today</a>
        </div>
    </div>
</div>
