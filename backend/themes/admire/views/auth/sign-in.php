<?php

use kartik\form\ActiveForm;
use rmrevin\yii\fontawesome\FA;

/**
 * The view file for the "auth/sign-in" action.
 *
 * @var \yii\web\View $this
 * @var \kodi\backend\models\forms\SignInForm $model
 */

$this->title = Yii::t('backend', 'Sign In');
?>

<div class="container">
    <div class="row text-center text-muted">
        <div class="col-md-4 mx-auto">
            <h1 class="logo-name"><?= Yii::$app->name; ?></h1>

            <h3><?= Yii::t('backend', 'Kodi Backend') ?></h3>
            <p><?= Yii::t('backend', 'Please close this page if you are not a part of Kodi team.'); ?></p>

            <? $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'email', [
                'addon' => [
                    'prepend' => ['content' => FA::i('envelope')],
                ],
            ])->textInput(['placeholder' => $model->getAttributeLabel('email')])->label(false); ?>
            <?= $form->field($model, 'password', [
                'addon' => [
                    'prepend' => ['content' => FA::i('lock')],
                ],
            ])->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false); ?>

            <button type="submit" class="btn btn-primary btn-block mb-5">
                <?= Yii::t('backend', 'Enter') ?>
            </button>
            <? $form->end() ?>

            <p class="m-t">
                <small>&copy; KODI <?= date('Y') ?></small>
            </p>
        </div>
    </div>
</div>
