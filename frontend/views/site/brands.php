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
                Stampiamo &nbsp;&nbsp;<br>
                Consegnamo &nbsp;&nbsp;<br>
                Connettiamo &nbsp;&nbsp;
            </div>
            <div class="stamp-i stamp-i-3"></div>
            <div class="stamp-i stamp-i-4"></div>
        </div>
        <div class="stamp-r">
            <div class="stamp-i stamp-i-1"></div>
            <div class="stamp-i stamp-i-2"></div>
            <div>
                &nbsp;&nbsp;Le tue<br>
                &nbsp;&nbsp;pubblicità<br>
                &nbsp;&nbsp;<span>ai tuoi clienti</span>
            </div>
        </div>
    </div>
</div>

<div class="brands-intro">
    <div class="bi-title">
        La tua pubblicita<br>
        diventa reale
    </div>
    <div class="bi-desc bi-desc-1">
        Gli utenti kodiplus ricevono<br>
        gratuitamente 10 foto ogni mese<br>
        Non applichiamo stampiamo nessun<br>
        tipo di pubblicità sulle foto
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
        Pubblicizza ciò che desideri:<br>
        un coupon, un nuovo corso in palestra, un evento,<br>
        un nuovo prodotto. O diffondi un tuo artwork,<br>
        invia un ringraziamento ai tuoi clienti.
    </div>
</div>

<div class="brands-desc">
    <div class="bd-title">scopri come funziona</div>
    <div class="bd-containers">
        <div class="bd-left">
            <div class="bd-dots-1"></div>
            <p>
                Scarica l’app <a href="/plus">KodiPlus</a> e switcha l’account in brand: un’interfaccia semplice che ti consentirà di creare il tuo messaggio in pochi click
            </p>
            <div class="bd-dots-3"></div>
            <p>
                Ottieni sempre una comunicazione 1:1, ricevendo il massimo dell’attenzione dal cliente.
                La tua pubblicità stampata ha un valore totalmente diverso.
            </p>
        </div>
        <div class="bd-right">
            <div class="bd-dots-2"></div>
            <p>
                Con Kodi Ads raggiungerai sempre persone reali
                Configura Reinventa la tua pubblicità in maniera nuova a seconda delle tue esigenze.
            </p>
            <div class="bd-dots-4"></div>
            <p>
                0 rischi clickbait, 0 bot, 0 spam.
                La tua pubblicità avrà un’efficacia del cento per cento.
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
            <?= Html::submitButton(Yii::t('frontend', 'richiedi prova gratuila'), ['class' => 'btn btn-block']); ?>
        </div>
        <? $form->end() ?>
    </div>
</div>

<?= $this->render('_brands_numbers'); ?>

<div class="brands-subscribe" id="member">
    <div class="b-s-title">
        Noi siamo pronti, tu?
    </div>
    <div class="b-s-desc">
        Cambia forma alla tua pubblicità già da oggi con Kodi Ads.
    </div>
    <div class="bs-subscribe">
        <? $form = ActiveForm::begin(); ?>
        <?= $form->field($becomeBrandModel, 'email')->textInput([
            'placeholder' => Yii::t('frontend', 'type in your email'),
            'class' => 'subscribe-email',
        ])->label(false); ?>
        <div class="wrap">
            <?= Html::submitButton(Yii::t('frontend', 'richiedi prova gratuila'), ['class' => 'btn btn-block']); ?>
        </div>
        <? $form->end() ?>
    </div>
</div>

<div class="b-i-block">
    <div class="b-i-title">
        cambia le regole<br>del tuo negozio
    </div>
    aggiungi nuove funzioni e ottieni<br>una comunicazione diversa
    <br>
    <a class="btn text-blue" href="/point">kodi point</a>
</div>
<div class="b-i-block">
    <div class="b-i-title">
        stampa gratuitamente<br>le foto che ami
    </div>
    scopri kodiplus, l’applicazione più facile del<br>al mondo per stampare i tuoi ricordi
    <br>
    <a class="btn" href="/">kodi plus</a>
</div>
