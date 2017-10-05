<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $subscribeModel \kodi\frontend\models\forms\SubscribeForm */

$this->title = 'Kodi';
$homeUrl = Yii::$app->homeUrl;

?>

<div class="content">
    <video id="video1" preload="auto" autoplay muted playsinline webkit-playsinline>
        <source src="<?= $homeUrl; ?>styles/video/kodicomingsoon-h264.mp4" type="video/mp4">
        <div class="content-text"></div>
    </video>
</div>
<div class="subscribe-container">
    <? $form = ActiveForm::begin(); ?>
    <?= $form->field($subscribeModel, 'email')->textInput([
        'placeholder' => Yii::t('frontend', 'your email'),
        'class' => 'subscribe-email',
    ])->label(false); ?>
    <?= Html::submitButton('stay tuned', ['class' => 'subscribe-button']); ?>
    <? $form->end() ?>
</div>
