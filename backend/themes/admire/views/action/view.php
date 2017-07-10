<?php

use kdn\yii2\JsonEditor;
use kodi\common\enums\PromoCodeStatus;
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
            <div class="card-header bg-white"><?= Yii::t('backend', 'Actions') ?></div>
            <div class="card-block m-t-35">
                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'initiator',
                            'initiator_id',
                            'type',
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
                            'created_at:datetime',
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
