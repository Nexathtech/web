<?php

use Carbon\Carbon;
use kartik\daterange\DateRangePicker;
use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * Partial file for event create/update form
 *
 * @var $model \kodi\common\models\event\Event
 */
$submitButtonTitle = $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update');
if (!$model->isNewRecord) {
    $this->registerJs("
    $(document).on('click', '.current-logo-delete', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/event/delete-logo?id={$model->id}',
            success: function(data) {
                if (data.status === 'success') {
                    $('.current-logo').remove();
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
    <? if (!empty($model->logo)): ?>
        <div class="current-logo">
            <img src="<?= $model->logo; ?>">
            <button type="button" class="btn btn-labeled btn-danger current-logo-delete">
                <span class="btn-label"><?= FA::i('close'); ?></span>
                <?= Yii::t('backend', 'Remove current logo'); ?>
            </button>
        </div>
    <? endif; ?>
    <?= $form->field($model, 'logo')->fileInput() ?>
    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'starts_at')->widget(DateRangePicker::class, [
        'convertFormat' => true,
        'options' => [
            'class' => 'form-control',
            'placeholder' => Yii::t('backend', 'Select start date...'),
        ],
        'pluginOptions' => [
            'timePicker' => true,
            'timePickerIncrement' => 60,
            'locale' => [
                'format'=>'Y-m-d H:i:s',
                'startDate' => date('Y-m-d H:i:s'),
            ],
        ]
    ]); ?>
    <div class="mb-2">
        <?= Yii::t('backend', 'Note, use the server time.') ?>
        <strong><?= Yii::t('backend', 'Current server time') ?>:</strong>
        <?= Carbon::now()->format('Y-m-d H:i:s') ?>
    </div>
    <?= $form->field($model, 'location_latitude')->textInput() ?>
    <?= $form->field($model, 'location_longitude')->textInput() ?>
    <?= $form->field($model, 'location_radius')->textInput() ?>
    <?= $form->field($model, 'users_max_prints_amount')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(Status::listData()) ?>
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
