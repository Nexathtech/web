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
        <li><a href="#advisors" data-section="advisors">.advisors</a></li>
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
        <div class="team-member tm-alex">
            <div class="member-photo">
                <img src="/images/team/alex/1.png">
                <img src="/images/team/alex/1-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/alex/2.png">
                <img src="/images/team/alex/2-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/alex/3.png">
                <img src="/images/team/alex/3-1.png">
            </div>
            <div class="member-info">
                alex specchio
                <br>// <span>co-founder</span>
            </div>
            <a class="member-contact" href="https://www.linkedin.com/in/alex-specchio-bb012611/" target="_blank" title="<?= Yii::t('frontend', 'Connect') ?>"></a>
        </div>
        <div class="team-member tm-ivan">
            <div class="member-photo">
                <img src="/images/team/ivan/1.png">
                <img src="/images/team/ivan/1-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/ivan/2.png">
                <img src="/images/team/ivan/2-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/ivan/3.png">
                <img src="/images/team/ivan/3-1.png">
            </div>
            <div class="member-info">
                ivan specchio<br>
                // <span>co-founder</span>
            </div>
            <a class="member-contact" href="https://www.linkedin.com/in/ivan-specchio-34661a12a/" target="_blank" title="<?= Yii::t('frontend', 'Connect') ?>"></a>
        </div>
        <div class="team-member tm-mykola">
            <div class="member-photo">
                <img src="/images/team/mykola/1.png">
                <img src="/images/team/mykola/1-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/mykola/2.png">
                <img src="/images/team/mykola/2-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/mykola/3.png">
                <img src="/images/team/mykola/3-1.png">
            </div>
            <div class="member-info">
                mykola popko<br>// <span>cto</span>
            </div>
            <a class="member-contact" href="https://www.linkedin.com/in/mykola-popko/" target="_blank" title="<?= Yii::t('frontend', 'Connect') ?>"></a>
        </div>
        <div class="team-member tm-dmitry">
            <div class="member-photo">
                <img src="/images/team/dmitry/1.png">
                <img src="/images/team/dmitry/1-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/dmitry/2.png">
                <img src="/images/team/dmitry/2-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/dmitry/3.png">
                <img src="/images/team/dmitry/3-1.png">
            </div>
            <div class="member-info">
                dmitry nartov<br>
                // <span>mobile developer</span>
            </div>
            <a class="member-contact" href="https://www.linkedin.com/in/nartich/" target="_blank" title="<?= Yii::t('frontend', 'Connect') ?>"></a>
        </div>
        <div class="team-member tm-jorge">
            <div class="member-photo">
                <img src="/images/team/jorge/1.png">
                <img src="/images/team/jorge/1-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/jorge/2.png">
                <img src="/images/team/jorge/2-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/jorge/3.png">
                <img src="/images/team/jorge/3-1.png">
            </div>
            <div class="member-info">
                jorge arrigo<br>
                // <span>kodi ambassador</span>
            </div>
            <a class="member-contact" href="https://www.linkedin.com/in/jorgearrigo/" target="_blank" title="<?= Yii::t('frontend', 'Connect') ?>"></a>
        </div>
        <div class="team-member tm-alisa">
            <div class="member-photo">
                <img src="/images/team/alisa/1.png">
                <img src="/images/team/alisa/1-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/alisa/2.png">
                <img src="/images/team/alisa/2-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/alisa/3.png">
                <img src="/images/team/alisa/3-1.png">
            </div>
            <div class="member-info">
                alisa sozonik<br>
                // <span>graphic designer</span>
            </div>
            <a class="member-contact" href="https://www.linkedin.com" target="_blank" title="<?= Yii::t('frontend', 'Connect') ?>"></a>
        </div>
        <div class="team-member tm-andrea">
            <div class="member-photo">
                <img src="/images/team/andrea/1.png">
                <img src="/images/team/andrea/1-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/andrea/2.png">
                <img src="/images/team/andrea/2-1.png">
            </div>
            <div class="member-photo">
                <img src="/images/team/andrea/3.png">
                <img src="/images/team/andrea/3-1.png">
            </div>
            <div class="member-info">
                andrea ravalli<br>
                // <span>graphic designer</span>
            </div>
            <a class="member-contact" href="https://www.linkedin.com" target="_blank" title="<?= Yii::t('frontend', 'Connect') ?>"></a>
        </div>
    </div>
    <div class="section-block section-advisors">
        <div class="advisor-member am-1">
            <img src="/images/advisors/1.png">
            <div class="advisor-info">
                <div class="am-title">Osvaldo Glatt</div>
                mechanical<br>engineer<br>advisor
            </div>
        </div>
        <div class="advisor-member am-2">
            <img src="/images/advisors/2.png">
            <div class="advisor-info">
                <div class="am-title">Clinton Donnely</div>
                mechanical<br>engineer<br>advisor
            </div>
        </div>
        <br>
        <div class="advisor-member am-3">
            <img src="/images/advisors/3.png">
            <div class="advisor-info">
                <div class="am-title">Ren Moulton</div>
                mechanical<br>engineer<br>advisor
            </div>
        </div>
        <div class="advisor-member am-4">
            <img src="/images/advisors/4.png">
            <div class="advisor-info">
                <div class="am-title">Nikita Bezlepkin</div>
                mechanical<br>engineer<br>advisor
            </div>
        </div>
    </div>
</div>
