<?php

/**
 * The view file for the "site/about" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\frontend\models\forms\ContactForm content
 * @see \kodi\frontend\controllers\SiteController::actionAbout()
 */


use kodi\frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('frontend', 'About');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/about.js', ['depends' => AppAsset::class]);
?>

<div class="page-about">
    <ul class="about-menu">
        <li><a href="#about" data-section="about" class="active">.about kodi</a></li>
        <li><a href="#contact" data-section="contact">.contact</a></li>
        <li><a href="#team" data-section="team">.the team</a></li>
    </ul>
    <div class="section-block section-about">
        <div class="about-title">
            connecting<br>everything you<br>love
        </div>
        <div class="about-content">
            Kodi is an open source platform that allows users to interact easily and directly with applications within the world of Kodi.<br>
            Each product within the project is interconnected to allow a safe and simple flow.<br>
            The system is oriented for interactivity, flexibility and diverse values: the Kodi philosophy allows each user to find their own path within the possibilities offered.<br>
            Creatives, startups, innovators, students and entrepreneurs can redesign an idea through the channels offered by the Kodi system.<br>
            Thanks to the infinite possibilities of printing and the open system technology, Kodi Stations, Kodi Plus and the Kodi community, Kodi is a diverse mixture of creative opportunities that are constantly evolving.
        </div>
    </div>
    <div class="section-block section-contact">
        <div class="contact-title">
            <?= Yii::t('frontend', 'don\'t{br}be shy', ['br' => '<br>']) ?>
            <div class="content-title-desc">
                <?= Yii::t('frontend', 'if you need some information, If you want Just to say hi, or if you wish to to know our favorite pizza, just fill in the form on the left and submit your request.'); ?>
            </div>
        </div>
        <div class="contact-content">
            <?= Yii::t('frontend', 'Dear Kodi') ?>,
            <div class="contact-form">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <div class="row">
                    <?= $form->field($model, 'body')->textarea([
                        'placeholder' => Yii::t('frontend', 'write your message'),
                    ])->label(false); ?>
                </div>
                <div class="row align-right">
                    <?= $form->field($model, 'email')->textInput([
                        'class' => 'contact-email',
                        'placeholder' => Yii::t('frontend', 'your email'),
                    ])->label(false); ?>
                </div>
                <div class="row align-right">
                    <?= Html::submitButton(Yii::t('frontend', 'send'), ['class' => 'btn btn-submit']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="section-block section-team">
        <div class="team-desc">
            <?= Yii::t('frontend', 'We are young') ?><br>
            (<?= Yii::t('frontend', 'Some younger than others') ?>)<br>
            <?= Yii::t('frontend', 'Good-looking') ?><br>
            (<?= Yii::t('frontend', 'This one is disputable') ?>)<br>
            <?= Yii::t('frontend', 'Diverse') ?><br>
            (<?= Yii::t('frontend', 'To the extreme') ?>)<br>
            <span><?= Yii::t('frontend', 'But we all love pizza') ?></span>
        </div>
        <div class="team-member">
            <div class="member-photo"><img src="/styles/img/member-photo-1.jpg">
            </div>
            <div class="member-photo"><img src="/styles/img/member-photo-2.jpg">
            </div>
            <div class="member-photo"><img src="/styles/img/member-photo-3.jpg">
            </div>
            <div class="member-info">
                alex<br>specchio// <span>founder</span>
            </div>
        </div>
        <div class="team-member">
            <div class="member-photo"><img src="/styles/img/member-photo-1.jpg">
            </div>
            <div class="member-photo"><img src="/styles/img/member-photo-2.jpg">
            </div>
            <div class="member-photo"><img src="/styles/img/member-photo-3.jpg">
            </div>
            <div class="member-info">
                ivan<br>specchio// <span>founder</span>
            </div>
        </div>
        <div class="team-member">
            <div class="member-photo"><img src="/styles/img/member-photo-1.jpg">
            </div>
            <div class="member-photo"><img src="/styles/img/member-photo-2.jpg">
            </div>
            <div class="member-photo"><img src="/styles/img/member-photo-3.jpg">
            </div>
            <div class="member-info">
                alise<br>sozonik// <span>designer</span>
            </div>
        </div>
        <div class="team-member">
            <div class="member-photo"><img src="/styles/img/member-photo-1.jpg">
            </div>
            <div class="member-photo"><img src="/styles/img/member-photo-2.jpg">
            </div>
            <div class="member-photo"><img src="/styles/img/member-photo-3.jpg">
            </div>
            <div class="member-info">
                mykola<br>popko// <span>developer</span>
            </div>
        </div>
        <!--<div class="team-description">
            We are young (some younger than others)<br>
            good-looking (this one is disputable)<br>
            diverse (to the extreme)<br>
            and<br>
            <strong>we all love pizza</strong>
        </div>-->
    </div>
</div>
