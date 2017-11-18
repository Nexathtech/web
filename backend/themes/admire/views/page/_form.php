<?php

use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/**
 * Partial file for device create/update form
 *
 * @var $model \kodi\common\models\page\Page
 */

$submitButtonTitle = $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update');

echo \vova07\imperavi\Widget::widget([
    'selector' => '#page-text',
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
        'imageUpload' => Url::to(['/default/image-upload']),
        'imageManagerJson' => Url::to(['/default/images-get']),
        'plugins' => [
            'imagemanager',
            //'fullscreen'
        ],
        'replaceDivs' => false,
        'removeWithoutAttr' => [],
    ]
]);

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>
<div class="card-header bg-white"><?= Yii::t('backend', 'Record details') ?></div>

<div class="card-block m-t-35">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'script')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'meta_description')->textarea() ?>
    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
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
