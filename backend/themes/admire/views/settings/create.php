<?php

use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;
use kodi\common\enums\setting\Type;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * View file for "Create new setting variable" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\Setting $model
 * @var $bunches array
 *
 * @see \kodi\backend\controllers\SettingsController::actionCreate()
 */

$this->title = Yii::t('backend', 'Create new variable');
$this->params['description'] = Yii::t('backend', 'General settings');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'General settings'),
        'url' => ['/settings'],
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
                <?= $form->field($model, 'title')->textInput() ?>
                <?= $form->field($model, 'description')->textarea() ?>
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'value')->textInput() ?>
                <?= $form->field($model, 'bunch')->widget(SelectizeDropDownList::class, [
                    'items' => $bunches,
                    'clientOptions' => [
                        'maxItems' => 1,
                        'persist' => false,
                        'create' => true,
                    ]
                ]) ?>
                <?= $form->field($model, 'type')->dropDownList(Type::listData()) ?>
                <?= $form->field($model, 'sort_order')->textInput() ?>
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
