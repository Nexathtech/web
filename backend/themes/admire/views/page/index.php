<?php

use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use kodi\backend\themes\admire\widgets\grid\ActionColumn;
use kodi\backend\themes\admire\widgets\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * View file for the "List pages" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\page\search\Page $searchModel
 * @var \yii\data\ActiveDataProvider $dataProvider
 *
 * @see \kodi\backend\controllers\PageController::actionIndex()
 */

$this->title = Yii::t('backend', 'Page management');
$this->params['description'] = FA::i('file-text') . ' ' . Yii::t('backend', 'Kodi pages');
$this->params['breadcrumbs'] = [
    $this->title,
];
?>

<!-- Search results -->
<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white">
                <?= Yii::t('backend', 'Pages list') ?>
                <a href="<?= Url::to(['/page/create']) ?>" id="editable_table_new" class="btn btn-default pull-right">
                    <?= FA::i('plus'); ?>
                    <?= Yii::t('backend', 'Add page'); ?>
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
                            'title',
                            'alias',
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
                            ],
                        ],
                    ]);

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
