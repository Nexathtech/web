<?php

use kartik\date\DatePicker;
use kdn\yii2\JsonEditor;
use kodi\common\enums\promocode\Status as PromoCodeStatus;
use kodi\common\enums\promocode\Type as PromoCodeType;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * Partial file for promo code create/update form
 *
 * @var $model \kodi\common\models\promocode\PromoCode
 */
$submitButtonTitle = $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update');
?>

<? $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>
<div class="card-header bg-white"><?= Yii::t('backend', 'Record details') ?></div>
<div class="card-block m-t-35">
    <?= $form->field($model, 'code')->textInput() ?>
    <?= $form->field($model, 'identity_id')->textInput() ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'data')->widget(JsonEditor::class, [
        'clientOptions' => ['modes' => ['code', 'tree']],
    ]); ?>
    <?= $form->field($model, 'type')->dropDownList(PromoCodeType::listData()) ?>
    <?= $form->field($model, 'status')->dropDownList(PromoCodeStatus::listData()) ?>
    <?= $form->field($model, 'expires_at')->widget(DatePicker::class, [
        'options' => ['placeholder' => Yii::t('backend', 'Select expiration date...')],
        'layout' => '{input}{picker}',
        'pluginOptions' => [
            'format' => 'yyyy-mm-d',
            'todayHighlight' => true,
            'autoclose' => true,
        ]
    ]); ?>
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
