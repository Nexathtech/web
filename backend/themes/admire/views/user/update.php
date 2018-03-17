<?php

use kodi\common\enums\setting\Type;
use kodi\common\enums\user\Role;
use kodi\common\enums\user\Status;
use kodi\common\enums\user\Type as UserType;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;
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
                <?= $form->field($model->profile, 'surname')->textInput() ?>
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
                <?= $form->field($model, 'type')->dropDownList(UserType::listData()) ?>
                <?= $form->field($model, 'status')->dropDownList(Status::listData()) ?>
                <?= $form->field($model->profile, 'country')->textInput() ?>
                <?= $form->field($model->profile, 'city')->textInput() ?>
                <?= $form->field($model->profile, 'state')->textInput() ?>
                <?= $form->field($model->profile, 'address')->textInput() ?>
                <?= $form->field($model->profile, 'postcode')->textInput() ?>
                <?= $form->field($model, 'new_password')->passwordInput() ?>
                <fieldset>
                    <h3><?= Yii::t('backend', 'Settings'); ?></h3>
                    <?
                    foreach ($model->settings as $field) {
                        if ($field->type === Type::INPUT) {
                            echo $form->field($field, "[{$field->key}]value")->label($field->title);
                        }
                        if ($field->type === Type::SELECT) {
                            $options = Json::decode($field->options);
                            echo $form->field($field, "[{$field->key}]value")->dropDownList($options)->label($field->title);
                        }
                    }
                    ?>
                </fieldset>
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
