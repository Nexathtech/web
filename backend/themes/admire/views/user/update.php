<?php

use kodi\common\enums\user\Role;
use kodi\common\enums\user\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * View file for "Update user's account" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\user\User $model
 *
 * @see \kodi\backend\controllers\UserController::actionUpdate()
 */

$this->title = Yii::t('backend', 'Update user "{name}"', ['name' => Html::encode($model->profile->name)]);
$this->params['description'] = Yii::t('backend', 'System users');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'User management'),
        'url' => ['/user'],
    ],
    $this->title,
];
$this->registerJs("
    $(document).on('click', '.current-photo-delete', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/user/delete-photo?id={$model->id}',
            success: function(data) {
                if (data.status === 'success') {
                    $('.current-photo').remove();
                }
            }
        });
    });
");
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="card-header bg-white"><?= Yii::t('backend', 'Record details') ?></div>
            <div class="card-block m-t-35">
                <?= $form->field($model->profile, 'name')->textInput() ?>
                <? if (!empty($model->profile->photo)): ?>
                    <div class="current-photo">
                        <img src="<?= $model->profile->photo; ?>">
                        <button type="button" class="btn btn-labeled btn-danger current-photo-delete">
                            <span class="btn-label"><?= FA::i('close'); ?></span>
                            <?= Yii::t('backend', 'Remove current photo'); ?>
                        </button>
                    </div>
                <? endif; ?>
                <?= $form->field($model->profile, 'photo')->fileInput() ?>
                <?= $form->field($model, 'role')->dropDownList(Role::listData()) ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'status')->dropDownList(Status::listData()) ?>
                <?= $form->field($model, 'new_password')->passwordInput() ?>
            </div>
            <div class="card-footer">
                <a class="btn btn-sm btn-white" href="<?= Url::to(['index']) ?>">
                    <?= FA::icon('times') ?>
                    <?= Yii::t('backend', 'Cancel') ?>
                </a>
                <?=
                Html::submitButton(
                    FA::icon('floppy-o') . '&nbsp;' . Yii::t('backend', 'Update'),
                    ['class' => 'btn btn-primary']
                )
                ?>
            </div>
            <? $form->end() ?>
        </div>
    </div>
</div>
