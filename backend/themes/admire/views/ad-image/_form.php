<?php

use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * Partial file for ad image create/update form
 *
 * @var $model \kodi\common\models\AdImage
 */
$submitButtonTitle = $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update');
?>

<? $form = ActiveForm::begin(); ?>
<div class="card-header bg-white"><?= Yii::t('backend', 'Record details') ?></div>
<div class="card-block m-t-35">
    <? if (!empty($model->image)): ?>
        <div class="current-photo">
            <img src="<?= $model->image; ?>">
        </div>
    <? endif; ?>
    <?= $model->isNewRecord ? $form->field($model, 'image')->fileInput() : '' ?>
    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(Status::listData()) ?>
    <?= $form->field($model, 'location_latitude')->textInput() ?>
    <?= $form->field($model, 'location_longitude')->textInput() ?>
</div>
<div class="card-footer">
    <a class="btn btn-sm btn-white" href="<?= Url::to(['index']) ?>">
        <?= FA::icon('times') ?>
        <?= Yii::t('backend', 'Cancel') ?>
    </a>
    <?=
    Html::submitButton(
        FA::icon('floppy-o') . '&nbsp;' . $submitButtonTitle,
        ['class' => 'btn btn-primary']
    )
    ?>
</div>
<? $form->end() ?>
