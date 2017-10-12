<?php

use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * The view file for the "List devices" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\device\Device $model
 *
 * @see \kodi\backend\controllers\DeviceController::actionView()
 */

$this->title = Yii::t('backend', 'View device "{name}"', ['name' => Html::encode($model->name)]);
$this->params['description'] = FA::i('user') . ' ' . Yii::t('backend', 'Kodi devices');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Device management'),
        'url' => ['/device'],
    ],
    $this->title,
];
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white"><?= Yii::t('backend', 'Devices list') ?></div>
            <div class="card-block m-t-35">
                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'uuid',
                            [
                                'attribute' => 'user_id',
                                'label' => Yii::t('backend', 'Owner'),
                                'format' => 'raw',
                                'value' => Html::a("{$model->user->profile->name} ({$model->user->email})", ['/user', 'id' => $model->user_id], ['target' => '_blank']),
                            ],
                            'type',
                            'name',
                            [
                                'attribute' => 'photo',
                                'format' => ['image', ['style' => 'max-width: 120px;']],
                            ],
                            [
                                'label' => $model->getAttributeLabel('status'),
                                'format' => 'html',
                                'value' => Html::tag('span', $model->status, [
                                    'class' => ($model->status == Status::ACTIVE) ? 'label label-success' : 'label label-default',
                                ]),
                            ],
                            'location_latitude',
                            'location_longitude',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
