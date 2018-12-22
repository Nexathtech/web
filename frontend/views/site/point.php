<?php

use kodi\frontend\assets\AppAsset;
use kodi\frontend\assets\SkrollrAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
    <div class="pbq-t1">Hai ricevuto un nostro segnalibro?</div>
    <div class="pbq-t2">Ti stavamo aspettando!</div>
    <div class="pbq-checks">
        <span class="pbq-check" data-state="1">si</span>
        <span class="pbq-check" data-state="0">no</span>
    </div>
    <div class="pbq-desc">
        Abbiamo selezionatoil tuo negozioperche riteniamo obbia tutti i requisiti per diventare un Kodi Point.<br>
        Ottieni le nostre coupon card e completa l'upgrade!
    </div>
    <a href="/downloadapp" class="btn text-black">ottieni coupon card</a>
</div>

<div class="point-men">
    <div class="point-men-cont">
        <div class="p-m-title">
            facilisssi-<br>
            ississisisi-<br>
            mo.
        </div>
        <div class="p-m-desc">
            Hai un negozio? Un ristorante? un’attività commerciale di qualsiasi genere?<br>
            Allora sei nel posto giusto! Kodi Point è la soluzione per te.<br>
            Entra a far parte di una community in costante crescita e scopri nuove funzionalità
            riservate ai membri.
        </div>
    </div>
</div>

<div class="point-desc">
    <div class="pd-find">
        <div class="pd-find-title">scopri come</div>
        <div class="pd-row">
            <div class="pd-find-l pd-find-l-1">
                <img src="/images/specialsticker.png">
            </div>
            <div class="pd-find-r pd-find-r-1">
                <div class="pd-title">Special sticker</div>
                <div class="pd-desc">
                    Un vero Kodi Point ha bisogno uno sticker speciale<br>
                    Posizione lo sticker dove preferisci e comunica a tutti rapidamente che sei un partner ufficiale di Kodi.<br>
                    <span>Richiedilo subito, è gratis!</span>
                </div>
                <a href="/order" class="btn pd-btn text-black">richiedi ora</a>
            </div>
        </div>
        <div class="pd-row">
            <div class="pd-find-l pd-find-l-2">
                <div class="pd-title">Coupon cards</div>
                <div class="pd-desc">
                    E se stampare fosse un gioco?<br>
                    Con le nostre coupon cards offri ai tuoi clienti la possibilità di stampare foto extra con l’applicazione <a href="/">KodiPlus</a> in maniera totalmente gratuita.<br>
                    Gli utenti KodiPlus riceveranno notifiche push per farli entrare nel tuo negozio e richiederti i coupon.<br>
                    <span>Più si stampa, più funziona.</span> Scopri perchè con <a href="/brands">Kodi Ads</a>.
                </div>
                <a href="/order" class="btn pd-btn text-black">richiedi ora</a>
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
            Grazie alla goelocalizzazione, gli utenti di KodiPlus potranno ricevere notifiche quando si trovano in prossimita della tua attivita.
        </div>
        <div class="pf-figure"></div>
    </div>
    <div class="pf-desc pf-desc-2">
        <div class="pf-figure"></div>
        <div class="pfd-text">
            Diventa parte di un network in continua evoluzione con grandi obiettivi.
            Il tuo negozio non ha confini.
        </div>
    </div>
    <div class="pf-desc pf-desc-3">
        <div class="pfd-text">
            Crea un luogo di ritrovo e riconoscibile per utenti da qualsiasi parte del mondo. Ogni utente KodiPlus saprà che il tuo negozio è il posto giusto
        </div>
        <div class="pf-figure">
            <span class="pff-circle pff-circle-1"></span>
            <span class="pff-circle pff-circle-2"></span>
        </div>
    </div>
    <div class="pf-desc pf-desc-4">
        <div class="pf-figure"></div>
        <div class="pfd-text">
            Questo è solo l’inizio!<br>
            Diventa un Kodi Point oggi per crescere insieme a noi e seguire tutti i progetti di Kodi in cantiere.<br>
            Sconti speciali per i primi membri

        </div>
    </div>
</div>

<div class="point-order">
    <div class="p-o-title">Cosa aspetti?</div>
    <div class="p-o-desc">
        Scegli il piano che preferisci e diventa un Kodi Point in pochi click
    </div>
    <a href="/order" class="btn">diventa kodi point</a>
</div>

<div class="b-i-block">
    <div class="b-i-title">
        promuovi il tuo brand<br>in pochi istanti
    </div>
    scopri come raggiungere utenti veri<br>in maniera semplice
    <br>
    <a class="btn text-blue" href="/brands">kodi ads</a>
</div>

<div class="b-i-block">
    <div class="b-i-title">
        stampa gratuitamente<br>le foto che ami
    </div>
    scopri KodiPlus, l’applicazione più facile del<br>al mondo per stampare i tuoi ricordi
    <br>
    <a class="btn" href="/">kodi plus</a>
</div>
