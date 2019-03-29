<?php

use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * The view file for the "View event" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\event\Event $model
 *
 * @see \kodi\backend\controllers\EventController::actionView()
 */

$this->title = Yii::t('backend', 'View event "{name}"', ['name' => Html::encode($model->title)]);
$this->params['description'] = FA::i('user') . ' ' . Yii::t('backend', 'Kodi events');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Events management'),
        'url' => ['/event'],
    ],
    $this->title,
];
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white"><?= Yii::t('backend', 'Events list') ?></div>
            <div class="card-block m-t-35">
                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'title',
                            'description',
                            [
                                'attribute' => 'logo',
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
                            'location_radius',
                            'users_max_prints_amount',
                            'starts_at:datetime',
                            'ends_at:datetime',
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
