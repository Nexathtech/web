<?php

use kodi\frontend\assets\AppAsset;
use kodi\frontend\assets\SkrollrAsset;

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */


$this->title = Yii::t('frontend', 'Ads');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/styles/site/adsz.css', ['depends' => AppAsset::class]);
$this->registerCssFile('/styles/site/ads-medium.css', [
    'media' => 'only screen and (max-width: 1001px)',
    'data-skrollr-stylesheet' => '',
    'depends' => AppAsset::class
]);
$this->registerJsFile('/js/adsz.js', ['depends' => [AppAsset::class, SkrollrAsset::class]]);
?>

<div class="play">
    <img src="/images/child-piano.png" alt="">
    <div class="text">
        <h2>play different</h2>
        <div class="desc">
            <p>porta il tuo business ad un livello completamente nuovo.</p>
            <p>Kodiplus è il primo di stampa che permette di spedire l’immagine del</p>
            <p>tuo brand in una busta esclusiva dove avrà la massima visibilità.</p>
            <p>Kodi Advertisment è pensato per essere rapido , semplice e immediato,</p>
            <p>senza intermedari, perdite di tempo o conoscenze pregresse.</p>
            <p>La tua pubblicità assume un altro tono.</p>
        </div>
    </div>
</div>

<div class="numbers-wrapper" id="numbers-wrapper">
    <section class="numbers skrollable"
             data-1="top: 175%; display:block"
             data-1000="top: 45%; "
             data-1450="top: 45%"
             data-6250="top: 45% ;"
             data-7000="top: -100%;"
    >
        <div class="first number"
             data-1500="right: 15vw;"
             data-1750="right: 2.3vw;"
             data-2250="right: 26vw;"
             data-2750="right: 26vw;"
             data-3750="right: 2.3vw;"
        >
            <div class="digit"><span class="dot">.</span> 1
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>
        <div class="second number"
             data-1500="right: 26vw;"
             data-1750="right: 2.3vw;"
             data-3250="right: 2.3vw;"
             data-3750="right: 26vw;"
             data-4250="right: 26vw;"
             data-4750="right: 2.3vw;"
        >
            <div class="digit"><span class="dot">.</span> 2
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="third number"
             data-1500="right: 15vw;"
             data-1750="right: 2.3vw;"
             data-4750="right: 2.3vw;"
             data-5250="right: 26vw;"
             data-5750="right: 26vw;"
             data-6250="right: 2.3vw;"
        >

            <svg id="click-me" version="1.1"  xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px"
                 viewBox="0 0 42.585 42.585" style="enable-background:new 0 0 42.585 42.585;" xml:space="preserve">
<g>
    <g>
        <path d="M14.934,32.494c-0.276,0-0.5-0.224-0.5-0.5V15.632c0-1.93,1.481-3.5,3.303-3.5s3.303,1.57,3.303,3.5v10.637
			c0,0.276-0.224,0.5-0.5,0.5s-0.5-0.224-0.5-0.5V15.632c0-1.378-1.033-2.5-2.303-2.5s-2.303,1.122-2.303,2.5v16.361
			C15.434,32.27,15.21,32.494,14.934,32.494z"/>
        <path d="M17.099,42.585c-0.128,0-0.256-0.049-0.354-0.146l-7.413-7.412c-0.824-0.824-1.376-1.835-1.555-2.846
			c-0.189-1.076,0.062-2.025,0.708-2.67c1.287-1.288,3.415-1.255,4.745,0.074l2.056,2.056c0.195,0.195,0.195,0.512,0,0.707
			s-0.512,0.195-0.707,0l-2.056-2.056c-0.94-0.939-2.435-0.972-3.331-0.074c-0.409,0.409-0.562,1.044-0.43,1.79
			c0.143,0.811,0.596,1.632,1.277,2.313l7.413,7.412c0.195,0.195,0.195,0.512,0,0.707C17.355,42.537,17.227,42.585,17.099,42.585z"
        />
        <path d="M26.146,27.341c-0.276,0-0.5-0.224-0.5-0.5V24.32c0-1.115-1.033-2.021-2.303-2.021s-2.303,0.907-2.303,2.021v2.521
			c0,0.276-0.224,0.5-0.5,0.5s-0.5-0.224-0.5-0.5V24.32c0-1.666,1.482-3.021,3.303-3.021s3.303,1.355,3.303,3.021v2.521
			C26.646,27.118,26.422,27.341,26.146,27.341z"/>
        <path d="M31.75,27.341c-0.276,0-0.5-0.224-0.5-0.5v-2.104c0-0.87-1.054-1.604-2.302-1.604s-2.302,0.735-2.302,1.604v2.104
			c0,0.276-0.224,0.5-0.5,0.5s-0.5-0.224-0.5-0.5v-2.104c0-1.436,1.481-2.604,3.302-2.604s3.302,1.168,3.302,2.604v2.104
			C32.25,27.118,32.027,27.341,31.75,27.341z"/>
        <path d="M37.356,33.759c-0.276,0-0.5-0.224-0.5-0.5v-6.877c0-1.378-1.033-2.5-2.303-2.5c-1.357,0-2.303,0.648-2.303,1.229v1.729
			c0,0.276-0.224,0.5-0.5,0.5s-0.5-0.224-0.5-0.5v-1.729c0-1.25,1.451-2.229,3.303-2.229c1.821,0,3.303,1.57,3.303,3.5v6.877
			C37.856,33.536,37.632,33.759,37.356,33.759z"/>
        <path d="M33.356,42.582H17.138c-0.276,0-0.518-0.224-0.518-0.5s0.206-0.5,0.482-0.5h16.254c1.93,0,3.5-1.57,3.5-3.5v-5.396
			c0-0.276,0.224-0.5,0.5-0.5s0.5,0.224,0.5,0.5v5.396C37.856,40.563,35.837,42.582,33.356,42.582z"/>
    </g>
    <g>

        <path class="stripes" d="M17.737,7.197c-0.276,0-0.5-0.224-0.5-0.5V0.5c0-0.276,0.224-0.5,0.5-0.5s0.5,0.224,0.5,0.5v6.197
		C18.237,6.973,18.013,7.197,17.737,7.197z"/>
        <path class="stripes" d="M21.857,8.916c-0.128,0-0.256-0.049-0.354-0.146c-0.195-0.195-0.195-0.512,0-0.707l4.381-4.382
		c0.195-0.195,0.512-0.195,0.707,0s0.195,0.512,0,0.707L22.21,8.769C22.113,8.867,21.985,8.916,21.857,8.916z"/>
        <path class="stripes" d="M30.244,12.408h-6.197c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h6.197c0.276,0,0.5,0.224,0.5,0.5
		S30.521,12.408,30.244,12.408z"/>
        <path class="stripes" d="M13.617,8.916c-0.128,0-0.256-0.049-0.354-0.146L8.881,4.387c-0.195-0.195-0.195-0.512,0-0.707s0.512-0.195,0.707,0
 	l4.382,4.382c0.195,0.195,0.195,0.512,0,0.707C13.873,8.867,13.745,8.916,13.617,8.916z"/>
        <path class="stripes" d="M11.426,12.408H5.229c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h6.196c0.276,0,0.5,0.224,0.5,0.5
 	S11.702,12.408,11.426,12.408z"/>
    </g>

</g>
</svg>

            <div class="digit"><span class="dot">.</span> 3
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </section>

    <section class="ads-pages skrollable started" id="started"
             data-100="top: 190% ; display: flex ;  "
             data-1300="top: 53%"
             data-2500="display: flex"
             data-2600=" display:none;">
        <div class="description">
            <h2>make your business easy <span>today</span></h2>
            <div class="started-p">
                <p>ti servono solo 3 step</p>
                <p>per raggiungere</p>
                <p>milioni di persone</p>
                <p>direttamete a casa loro</p>
            </div>
        </div>
    </section>


    <section class="ads-pages figure skrollable" id="figure"
             data-1750="top: 50%; left: -50%; display: block; "
             data-2250="left: 50%"
             data-2750="display: flex;"
             data-6250="top: 50% ;"
             data-7000="top: -100%;"

    >
        <figure class="type-name">
            <img src="/images/phone.svg">
            <div class="wrap">
                <img class="screen" src="/images/group.png"
                     data-2750="bottom: 0%"
                     data-3750="bottom: 100%"
                >
            </div>
            <div class="wrap">
                <img class="screen" src="/images/2phone.jpg"
                     data-4250="bottom: 0%"
                     data-4750="bottom: 100%"

                >
            </div>
            <div class="wrap">
                <img class="screen" src="/images/3phone.jpg">
            </div>

        </figure>
    </section>

    <section class="ads-pages desc skrollable "
             data-2100="width: 0%;  left: 9%;  "
             data-2550="width: 100%; display: block"
             data-3600="left: -77%;"
    >
        <div class="description ">
            <h2>login as brands</h2>
            <p>seleziona un’immagine</p>
            <p>che rappresenti il tuo </p>
            <p>brand,</p>
            <p>il tuo prodotto o qualsiasi</p>
            <p>cosa tu voglia diffondere.</p>
        </div>
    </section>

    <section class="ads-pages desc skrollable"
             data-3250="left: -60%; "
             data-3750="left: 9%; display: flex;"
             data-4250="left: 9%;"
             data-4750="left: -77%; display: none; ;"
    >
        <div class="description">
            <h2>select image</h2>
            <p>seleziona un’immagine</p>
            <p>che rappresenti il tuo </p>
            <p>brand,</p>
            <p>il tuo prodotto o qualsiasi</p>
            <p>cosa tu voglia diffondere.</p>
        </div>
    </section>

    <section class="ads-pages desc skrollable"
             data-4750="left: -60%; "
             data-5250="left: 9%; display: flex; "
             data-5750="left: 9%;"
             data-6250="left: -77%; display: none;"
    >
        <div class="description">
            <h2>choose how</h2>
            <p>seleziona un’immagine</p>
            <p>che rappresenti il tuo </p>
            <p>brand,</p>
            <p>il tuo prodotto o qualsiasi</p>
            <p>cosa tu voglia diffondere.</p>
        </div>
    </section>

</div>

<div class="member">
    <div class="send">
        <figure>
            <img src="/images/faces.svg" alt="man">

        </figure>
        <h2>become a member in just few click</h2>

        <form action="">
            <input type="email" placeholder="type your email">
            <div class="wrap">
                <button>send</button>
            </div>
        </form>
        <div class="desc">
            <p>please inser your email and you will</p>
            <p>know asap about when is possible</p>
            <p>become a kodipoint</p>
        </div>

    </div>

    <div class="shop">
        <div class="title">
            <div class="text">your shop</div>
            <div class="text">become <span></span></div>
            <div class="text">a new shop</div>
        </div>
        <div class="desc">
            <p>il tuo business si ampia diventando un </p>
            <p>kodipoint autorizzato senza nessun costo </p>
            <p>aggiuntivo alla quota di iscrizione, nessun </p>
            <p>dispendio d’energia o manuale </p>
            <p>incomprensibile.</p>
        </div>
    </div>
</div>
<div class="superkit">
    <div class="title">the superkit <span></span></div>
    <div class="coupon">
        <h3>coupon cards</h3>
        <div class="block"></div>
        <p>coupon card disign</p>
        <p>collezionabili, illustrate da creativi</p>
        <p>di tutto il mondo. un tocco diverso</p>
        <p>nel tuo shop</p>
        <img src="/images/coupon.png" alt="coupon">
    </div>
    <div class="super">
        <img src="/images/Envelope.png" alt="">
        <h3>superpackaging</h3>
        <div class="block"></div>
        <p>coupon card disign</p>
        <p>collezionabili, illustrate da creativi</p>
        <p>di tutto il mondo. un tocco diverso</p>
        <p>nel tuo shop</p>
    </div>

    <div class="sticker">
        <h3>special sticker</h3>
        <div class="block"></div>
        <p>coupon card disign</p>
        <p>collezionabili, illustrate da creativi</p>
        <p>di tutto il mondo. un tocco diverso</p>
        <p>nel tuo shop</p>
        <img src="/images/sticker.png" alt="">
    </div>
</div>

<div class="damande">
    <div class="title">
        Domande frequenti
        <span></span>
    </div>
    <div class="man">
        <img src="/images/man.svg" alt="man">
        <p>here you can find answers to your doubts</p>
        <p>if you can't find</p>
        <p>what you are looking for,</p>
        <p>please <span>contact us</span></p>
    </div>
    <div class="desc">
        <div class="frequenti">
            <div class="headers">
                chi può diventare kodi point?
                <svg class="expand" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.61 20.03"><title>
                        plus-italic</title>
                    <g id="Layer_2" data-name="Layer 2">
                        <g id="Layer_1-2" data-name="Layer 1">
                            <path id="Line" class="fstripe" d="M10.81,1.11,8.67,18.91"
                                  style="fill:none;stroke:#ffaa05;stroke-linecap:square;stroke-width:2px"/>
                            <path id="Line-2" class="sstripe" data-name="Line" d="M1,8.78H18.61"
                                  style="fill:none;stroke:#ffaa05;stroke-linecap:square;stroke-width:2px"/>
                        </g>
                    </g>
                </svg>
            </div>
            <div class="description expand">
                <p>An outstanding design that is easily assembled,</p>
                <p>Kodi reinvents the digital kiosk design,</p>
                <p>functionality, and scope</p>
                <p>This bridge between the digital world and reality will</p>
                <p>provide</p>
            </div>
        </div>
        <div class="frequenti">
            <div class="headers">
                posso dare più di un coupon allo stesso cliente?
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.61 20.03"><title>plus-italic</title>
                    <g id="Layer_2" data-name="Layer 2">
                        <g id="Layer_1-2" data-name="Layer 1">
                            <path id="Line" class="fstripe" d="M10.81,1.11,8.67,18.91"
                                  style="fill:none;stroke:#ffaa05;stroke-linecap:square;stroke-width:2px"/>
                            <path id="Line-2" class="sstripe" data-name="Line" d="M1,8.78H18.61"
                                  style="fill:none;stroke:#ffaa05;stroke-linecap:square;stroke-width:2px"/>
                        </g>
                    </g>
                </svg>
            </div>
            <div class="description">
                <p>An outstanding design that is easily assembled,</p>
                <p>Kodi reinvents the digital kiosk design,</p>
                <p>functionality, and scope</p>
                <p>This bridge between the digital world and reality will</p>
                <p>provide</p>
            </div>
        </div>
        <div class="frequenti">
            <div class="headers">
                come vengono calcolati i miei guadagni?
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.61 20.03"><title>plus-italic</title>
                    <g id="Layer_2" data-name="Layer 2">
                        <g id="Layer_1-2" data-name="Layer 1">
                            <path id="Line" class="fstripe" d="M10.81,1.11,8.67,18.91"
                                  style="fill:none;stroke:#ffaa05;stroke-linecap:square;stroke-width:2px"/>
                            <path id="Line-2" class="sstripe" data-name="Line" d="M1,8.78H18.61"
                                  style="fill:none;stroke:#ffaa05;stroke-linecap:square;stroke-width:2px"/>
                        </g>
                    </g>
                </svg>
            </div>
            <div class="description">
                <p>An outstanding design that is easily assembled,</p>
                <p>Kodi reinvents the digital kiosk design,</p>
                <p>functionality, and scope</p>
                <p>This bridge between the digital world and reality will</p>
                <p>provide</p>
            </div>
        </div>
        <div class="frequenti">
            <div class="headers">
                posso rappresentare più kodi point?
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.61 20.03"><title>plus-italic</title>
                    <g id="Layer_2" data-name="Layer 2">
                        <g id="Layer_1-2" data-name="Layer 1">
                            <path id="Line" class="fstripe" d="M10.81,1.11,8.67,18.91"
                                  style="fill:none;stroke:#ffaa05;stroke-linecap:square;stroke-width:2px"/>
                            <path id="Line-2" class="sstripe" data-name="Line" d="M1,8.78H18.61"
                                  style="fill:none;stroke:#ffaa05;stroke-linecap:square;stroke-width:2px"/>
                        </g>
                    </g>
                </svg>
            </div>
            <div class="description">
                <p>An outstanding design that is easily assembled,</p>
                <p>Kodi reinvents the digital kiosk design,</p>
                <p>functionality, and scope</p>
                <p>This bridge between the digital world and reality will</p>
                <p>provide</p>
            </div>
        </div>

    </div>
</div>
