<?php

use kartik\builder\Form;
use kartik\form\ActiveForm;

/**
 * The view file for the "auth/password-reset" action.
 *
 * @var \yii\web\View $this
 * @var \kodi\frontend\models\forms\ResetPasswordRequestForm $model
 * @var bool $isRecovery
 */

$this->title = Yii::t('frontend', 'Reset password');
?>

<div class="page-password-reset">

    <div class="container">
        <div class="row text-center">
            <div class="col-middle">
                <h3 class="dark-text text-title">
                    <strong><?= Yii::t('frontend', 'Password recovery') ?></strong>
                </h3>

                <? $form = ActiveForm::begin() ?>
                <?
                $attributes = (!$isRecovery) ?
                    [
                        'email' => [
                            'type' => Form::INPUT_HTML5,
                            'html5type' => 'email',
                            'label' => false,
                            'options' => [
                                'placeholder' => $model->getAttributeLabel('email'),
                                'class' => 'margin-top-sm',
                            ],
                        ]
                    ]
                    :
                    [
                        'password' => [
                            'type' => Form::INPUT_PASSWORD,
                            'label' => false,
                            'options' => [
                                'placeholder' => $model->getAttributeLabel('password'),
                                'class' => 'margin-top-sm',
                            ],
                        ]
                    ]
                ?>
                <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'attributes' => $attributes,
                ]);
                ?>
                <button type="submit" class="btn full-width">
                    <?= Yii::t('frontend', 'Submit') ?>
                </button>
                <? if (!$isRecovery): ?>
                    <p class="text-center help-block">
                        <?= Yii::t('frontend', 'Enter the email address you signed up with and we will send you a link so you can change your password.') ?>
                    </p>
                <? endif; ?>
                <? $form->end() ?>
            </div>
        </div>
    </div>
</div>
