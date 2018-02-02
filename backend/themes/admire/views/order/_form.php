<?php

use kodi\common\enums\order\PaymentType;
use kodi\common\enums\order\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * Partial file for order create/update form
 *
 * @var $model \kodi\common\models\Order
 */

$submitButtonTitle = $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update');
?>

<? $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>
<div class="card-header bg-white"><?= Yii::t('backend', 'Record details') ?></div>
<div class="card-block m-t-35">
    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'surname')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'company')->textInput() ?>
    <?= $form->field($model, 'country')->textInput() ?>
    <?= $form->field($model, 'city')->textInput() ?>
    <?= $form->field($model, 'state')->textInput() ?>
    <?= $form->field($model, 'address')->textInput() ?>
    <?= $form->field($model, 'postcode')->textInput() ?>
    <?= $form->field($model, 'color')->textInput() ?>
    <?= $form->field($model, 'quantity')->textInput() ?>
    <?= $form->field($model, 'total')->textInput() ?>
    <?= $form->field($model, 'payment_type')->dropDownList(PaymentType::listData()) ?>
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
