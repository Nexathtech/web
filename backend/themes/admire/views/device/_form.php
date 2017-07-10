<?php

use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * Partial file for device create/update form
 *
 * @var $model \kodi\common\models\device\Device
 */
$submitButtonTitle = $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update');
if (!$model->isNewRecord) {
    $this->registerJs("
    $(document).on('click', '.current-photo-delete', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/device/delete-photo?id={$model->id}',
            success: function(data) {
                if (data.status === 'success') {
                    $('.current-photo').remove();
                }
            }
        });
    });
");
}
?>

<? $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>
<div class="card-header bg-white"><?= Yii::t('backend', 'Record details') ?></div>
<div class="card-block m-t-35">
    <?= $form->field($model, 'name')->textInput() ?>
    <? if (!empty($model->photo)): ?>
        <div class="current-photo">
            <img src="<?= $model->photo; ?>">
            <button type="button" class="btn btn-labeled btn-danger current-photo-delete">
                <span class="btn-label"><?= FA::i('close'); ?></span>
                <?= Yii::t('backend', 'Remove current photo'); ?>
            </button>
        </div>
    <? endif; ?>
    <?= $form->field($model, 'photo')->fileInput() ?>
    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(Status::listData()) ?>
    <?= $form->field($model, 'access_token')->textInput() ?>
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
