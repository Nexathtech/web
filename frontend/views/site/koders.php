<?php

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\frontend\models\forms\ContactForm content
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */

$this->title = 'Koders';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-koders">
    <div class="which-koder">
        <div class="w-k-title">which koder are you?</div>
        <div class="figure-col">
            <div class="arch arch-blue"></div>
            <div class="arch arch-yellow"></div>
            <div class="teeth"></div>
        </div>
        <div class="figure-col">
            <div class="arch arch-red"></div>
            <div class="recv recv-violette"></div>
            <div class="mustache"></div>
        </div>
        <div class="figure-col">
            <div class="rech rech-pink"></div>
            <div class="arch arch-green"></div>
            <div class="eye eye-left"></div>
            <div class="eye eye-right"></div>
        </div>
        <div class="figure-col">
            <div class="arch arch-blue-light"></div>
            <div class="rech rech-violette"></div>
            <div class="nose"></div>
        </div>
    </div>
    <div class="work-annoying">
        <div class="w-a-title">who says work<br>is annooooying time??</div>
        <div class="work-figures">
            <div class="w-f-col">
                <div class="arch arch-pink"></div>
                <div class="arch arch-pink"></div>
                <div class="arch arch-black"></div>
                <div class="time-arrows"></div>
                <div class="basement-lines"></div>
                work when<br>you want
            </div>
            <div class="w-f-col">
                <div class="arch arch-yellow"></div>
                <div class="milkshake"></div>
                <p>drink a super<br>milkshake</p>
            </div>
            <div class="w-f-col">
                <div class="w-f-chart"></div>
                <div class="w-f-chart-2"></div>
                <div>work where<br>you want</div>
            </div>
            <div class="w-f-col w-f-col-4">
                <div class="arch arch-yellow"></div>
                <div class="arch arch-green-light"></div>
                <div class="arch arch-dark"></div>
                <p>receive your money<br>direct</p>
            </div>
        </div>
    </div>
    <div class="write-us-desc">
        <p>
            Maximum flexibility, the liberty to choose and to earn direct.<br>
            The required features:<br>
            Curiosity<br>
            Curiosity<br>
            Curiosity<br>
            And the ability to smile
        </p>
    </div>
    <div class="write-us-desc">
        Being a Koder will allow you to discover new places in your city,<br>
        get in touch with an innovative and creative network and earn<br>
        when you decide. You can install a new station, deliver prints,<br>
        find new locations and participate at exclusive events.
        <a class="btn btn-md" href="/about#contact">write us</a>
    </div>
    <div class="directly-to-public">
        <div class="dtp-cont">
            <div class="dtp-left">
                <div class="dtp-title">directly
                    <div>to</div>your public
                </div>
                <a class="btn btn-md" href="/station">explore</a>
            </div>
            <div class="dtp-middle">
                <div class="dtp-monitor"></div>
                <img class="dtp-1" src="styles/img/dtp-1.jpg">
                <img class="dtp-2" src="styles/img/dtp-2.jpg">
                <img class="dtp-3" src="styles/img/dtp-3.jpg">
            </div>
            <div class="dtp-right">
                Create fantastic combinations and exhibit them direct to an audience.<br>
                Illustrators, graphic designers, photographers and visual designers can experience and show their talent and be chosen by the public for their print compositions by simply uploading their work on the Kodi platform.<br>
                This is an opportunity to earn, a bridge between creatives and people, all while cutting out all the other steps which this usually requires.<br>
                Find out about the solutions that you can create and become inspired to invent new and totally different combinations, by clicking explore.
            </div>
        </div>
    </div>
    <div class="b-i-block">
        <div class="b-i-title">what is exactly a<br>kodi station?</div>
        A kiosk with infinite possibilities...<br>
        <a class="btn" href="/station">kodi station</a>
    </div>
    <div class="b-i-block">
        <div class="b-i-title">No Kodi Station<br>near where you live?</div>
        No problem - Kodi Plus is the application which allows you to access all the functionality of a station direct from your smartphone.<br>
        <a class="btn text-blue" href="/plus">kodi plus</a>
    </div>
</div>
