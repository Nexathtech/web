<?php

use dosamigos\selectize\SelectizeTextInput;
use kartik\form\ActiveForm;
use kodi\common\enums\setting\Type;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * The view file for the "Settings" page.
 *
 * @var \yii\web\View $this
 * @var array $fields
 *
 * @see \kodi\backend\controllers\SettingsController::actionIndex()
 */

$this->title = Yii::t('backend', 'General Settings');
$this->params['description'] = Yii::t('backend', 'General settings');
$this->params['breadcrumbs'] = [
    $this->title,
];
$this->registerJs("
    $(document).on('click', '.current-photo-delete', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            type: 'post',
            url: '/settings/delete-photo?id=' + id,
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
    <div class="inner bg-container settings-container">
        <? $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
        ]); ?>
        <div class="card">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs float-xs-left">
                <? $i = 0; ?>
                <? foreach ($fields as $group => $settings): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($i === 0) ? 'active' : ''; ?>" data-toggle="tab" href="#group-<?= str_replace(' ', '-', $group); ?>">
                            <?= $group; ?>
                        </a>
                    </li>
                <? $i++; ?>
                <? endforeach; ?>
                </ul>
                <a href="/settings/create" class="btn btn-primary pull-right">
                    <?= FA::i('plus'); ?>
                    <?= Yii::t('backend', 'Add variable'); ?>
                </a>
            </div>

            <div class="card-block m-t-15">
                <div class="tab-content">
                <? $i = 0; ?>
                <? foreach ($fields as $group => $settings): ?>
                    <div class="tab-pane <?= ($i === 0) ? 'active' : ''; ?>" id="group-<?= str_replace(' ', '-', $group); ?>">
                    <? foreach ($settings as $field): ?>
                        <? /** @var $field \kodi\common\models\Setting */ ?>
                        <div class="row">
                            <div class="col-sm-12">
                            <?
                            $label = $field->title;
                            if (!empty($field->description)) {
                                $label .= ' &nbsp; ' . FA::i('question-circle-o', ['data-toggle' => 'tooltip', 'title' => $field->description]);
                            }

                            if ($field->type === Type::INPUT) {
                                echo $form->field($field, "[{$field->name}]value")->label($label);
                            }
                            if ($field->type === Type::TAG) {
                                echo $form->field($field, "[{$field->name}]value")->widget(SelectizeTextInput::class, [
                                    'clientOptions' => [
                                        'persist' => false,
                                        'create' => true,
                                    ]
                                ])->label($label);
                            }
                            if ($field->type === Type::PASSWORD) {
                                echo $form->field($field, "[{$field->name}]value")->passwordInput()->label($label);
                            }
                            if ($field->type === Type::TEXTAREA) {
                                echo $form->field($field, "[{$field->name}]value")->textarea()->label($label);
                            }
                            if ($field->type === Type::CHECKBOX) {
                                echo $form->field($field, "[{$field->name}]value")->checkbox([], false)->label($label);
                            }
                            if ($field->type === Type::IMAGE) {
                                echo Html::beginTag('div', ['class' => 'row']);
                                echo Html::beginTag('div', ['class' => 'col-sm-12']);
                                echo Html::beginTag('div', ['class' => 'form-group']);
                                echo Html::tag('label', $label, ['class' => 'control-label col-md-2']);
                                echo Html::beginTag('div', ['class' => 'col-md-10']);
                                if (!empty($field->value)) {
                                    echo Html::beginTag('div', ['class' => 'current-photo']);
                                    echo Html::img($field->value);
                                    echo Html::button(FA::i('close') . ' ' . Yii::t('backend', 'Remove watermark'), ['class' => 'btn btn-labeled btn-danger current-photo-delete', 'data-id' => $field->id]);
                                    echo Html::endTag('div');
                                }
                                echo $form->field($field, "[{$field->name}]value")->fileInput()->label(false);
                                echo Html::endTag('div');
                                echo Html::endTag('div');
                                echo Html::endTag('div');
                                echo Html::endTag('div');
                            }
                            ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                    </div>
                <? $i++; ?>
                <? endforeach; ?>
                </div>
            </div>

            <div class="card-footer">
                <a class="btn btn-sm btn-white" href="<?= Url::to(['/dashboard']) ?>">
                    <?= FA::icon('times') ?>
                    <?= Yii::t('backend', 'Cancel') ?>
                </a>
                <?=
                Html::submitButton(
                    FA::icon('floppy-o') . '&nbsp;' . Yii::t('backend', 'Save'),
                    ['class' => 'btn btn-primary']
                )
                ?>
            </div>
        </div>
        <? ActiveForm::end(); ?>
    </div>
</div>
