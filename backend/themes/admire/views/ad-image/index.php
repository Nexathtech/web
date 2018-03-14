<?php

use kodi\backend\themes\admire\widgets\grid\ActionColumn;
use kodi\backend\themes\admire\widgets\grid\GridView;
use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * The view file for the "List devices" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\AdImage $searchModel
 * @var \yii\data\ActiveDataProvider $dataProvider
 *
 * @see \kodi\backend\controllers\AdImageController::actionIndex()
 */

$this->title = Yii::t('backend', 'Advertisement images management');
$this->params['description'] = FA::i('camera-retro') . ' ' . Yii::t('backend', 'Advertisement images');
$this->params['breadcrumbs'] = [
    $this->title,
];
?>

<!-- Search results -->
<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white">
                <?= Yii::t('backend', 'Images list') ?>
                <a href="<?= Url::to(['/ad-image/create']) ?>" id="editable_table_new" class="btn btn-default pull-right">
                    <?= FA::i('plus'); ?>
                    <?= Yii::t('backend', 'Add image'); ?>
                </a>
            </div>
            <div class="card-block m-t-10">
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover dataTable no-footer'],
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'headerOptions' => ['class' => 'col-tiny'],
                                'filterOptions' => ['class' => 'col-tiny'],
                                'contentOptions' => ['class' => 'col-tiny'],
                            ],
                            [
                                'attribute' => 'image',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    /* @var $data \kodi\common\models\AdImage */
                                    return Html::img($data->image);
                                },
                                'contentOptions' => ['class' => 'image-col']
                            ],
                            [
                                'attribute' => 'user.email',
                                'label' => Yii::t('backend', 'Owner'),
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a(Html::encode($data->user->email), ['view', 'id' => $data->id]);
                                }
                            ],
                            'location_latitude',
                            'location_longitude',
                            'created_at',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => Status::listData(),
                                'value' => function ($data) {
                                    return Html::tag('span', $data->status, [
                                        'class' => ($data->status == Status::ACTIVE) ? 'label label-success' : 'label label-default'
                                    ]);
                                }
                            ],
                            [
                                'class' => ActionColumn::class,
                                'template' => '{update} &nbsp; {delete}',
                            ],
                        ],
                    ]);

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>