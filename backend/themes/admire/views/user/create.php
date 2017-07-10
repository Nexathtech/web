<?php

use kodi\common\enums\user\Role;
use kodi\common\enums\user\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * View file for "Create new user account" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\user\User $model
 * @var \kodi\common\models\user\Profile $profileModel
 *
 * @see \kodi\backend\controllers\UserController::actionUpdate()
 */

$this->title = Yii::t('backend', 'Create new user');
$this->params['description'] = Yii::t('backend', 'System users');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'User management'),
        'url' => ['/user'],
    ],
    $this->title,
];
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <?= $form->errorSummary($model); ?>
            <div class="card-header bg-white"><?= Yii::t('backend', 'Record details') ?></div>
            <div class="card-block m-t-35">
                <?= $form->field($profileModel, 'name')->textInput() ?>
                <?= $form->field($profileModel, 'photo')->fileInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'role')->dropDownList(Role::listData()) ?>
                <?= $form->field($model, 'status')->dropDownList(Status::listData()) ?>
            </div>
            <div class="card-footer">
                <a class="btn btn-sm btn-white" href="<?= Url::to(['index']) ?>">
                    <?= FA::icon('times') ?>
                    <?= Yii::t('backend', 'Cancel') ?>
                </a>
                <?=
                Html::submitButton(
                    FA::icon('floppy-o') . '&nbsp;' . Yii::t('backend', 'Create'),
                    ['class' => 'btn btn-primary']
                )
                ?>
            </div>
            <? $form->end() ?>
        </div>
    </div>
</div>
