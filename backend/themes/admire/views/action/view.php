<?php

use kdn\yii2\JsonEditor;
use kodi\common\enums\action\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * The view file for the "List actions" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\Action $model
 *
 * @see \kodi\backend\controllers\ActionController::actionView()
 */

$this->title = Yii::t('backend', 'View action "{id}"', ['id' => $model->id]);
$this->params['description'] = FA::i('bullseye') . ' ' . Yii::t('backend', 'Actions');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Actions management'),
        'url' => ['/action'],
    ],
    $this->title,
];
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header">
                <?= Yii::t('backend', 'Action') ?> #<?= $model->id ?>
                <?
                if ($model->status === Status::NEW) {
                    echo Html::a(FA::i('archive') . Yii::t('backend', 'Mark as archived'), ['archive', 'id' => $model->id], [
                        'class' => 'btn btn-warning btn-post pull-right'
                    ]);
                }
                ?>
            </div>
            <div class="card-block m-t-35">
                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'label' => Yii::t('backend', 'User'),
                                'format' => 'raw',
                                'value' => Html::a("{$model->user->profile->name} ({$model->user->email})", ['/user/view', 'id' => $model->user_id]),
                            ],
                            [
                                'label' => Yii::t('backend', 'Event'),
                                'format' => 'raw',
                                'value' => Html::a($model->event->title, ['/event/view', 'id' => $model->event_id]),
                            ],
                            [
                                'label' => Yii::t('backend', 'Device'),
                                'format' => 'raw',
                                'value' => Html::a($model->device->uuid, ['/device/view', 'id' => $model->device_id]),
                            ],
                            'device_type',
                            'action_type',
                            [
                                'attribute' => 'data',
                                'format' => 'raw',
                                'value' => JsonEditor::widget(
                                    [
                                        'clientOptions' => ['mode' => 'view'],
                                        'expandAll' => ['view'],
                                        'containerOptions' => ['style' => null],
                                        'name' => 'viewer',
                                        'value' => $model->data,
                                    ]
                                ),
                            ],
                            'promo_code',
                            'status',
                            'created_at:datetime',
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
