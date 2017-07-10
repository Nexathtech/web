<?php

use kodi\backend\themes\admire\widgets\grid\ActionColumn;
use kodi\backend\themes\admire\widgets\grid\GridView;
use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\FormatConverter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * The view file for the "List devices" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\device\search\Device $searchModel
 * @var \yii\data\ActiveDataProvider $dataProvider
 *
 * @see \kodi\backend\controllers\UserController::actionIndex()
 */

$this->title = Yii::t('backend', 'Device management');
$this->params['description'] = FA::i('android') . ' ' . Yii::t('backend', 'Kodi devices');
$this->params['breadcrumbs'] = [
    $this->title,
];
$dateRangePickerOptions = [
    'timePicker' => true,
    'timePickerIncrement' => 15,
    'timePicker24Hour' => true,
    'autoUpdateInput' => false,
    'opens' => 'left',
    'locale' => [
        'format' => FormatConverter::convertDateIcuToPhp('short', 'datetime'),
    ],
    'ranges' => [
        Yii::t('backend', "Today") => ["moment().startOf('day')", "moment()"],
        Yii::t('backend', "Yesterday") => ["moment().startOf('day').subtract(1,'days')", "moment().endOf('day').subtract(1,'days')"],
        Yii::t('backend', "Last {n} Days", ['n' => 7]) => ["moment().startOf('day').subtract(6, 'days')", "moment()"],
        Yii::t('backend', "Last {n} Days", ['n' => 30]) => ["moment().startOf('day').subtract(29, 'days')", "moment()"],
        Yii::t('backend', "This Month") => ["moment().startOf('month')", "moment().endOf('month')"],
        Yii::t('backend', "Last Month") => ["moment().subtract(1, 'month').startOf('month')", "moment().subtract(1, 'month').endOf('month')"],
    ],
];
$dateRangePickerEvents = [
    'apply.daterangepicker' =>
        "
            function (event, picker) {
                $(picker.element).val(
                    picker.startDate.format(picker.locale.format)
                    + picker.locale.separator
                    + picker.endDate.format(picker.locale.format)
                );
            }
        "

];
?>

<!-- Search results -->
<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white">
                <?= Yii::t('backend', 'Devices list') ?>
                <a href="<?= Url::to(['/device/create']) ?>" id="editable_table_new" class="btn btn-default pull-right">
                    <?= FA::i('plus'); ?>
                    <?= Yii::t('backend', 'Add device'); ?>
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
                                'attribute' => 'photo',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::img($data->getPhoto());
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
                            'name',
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
                                'attribute' => 'created_at',
                                'filter' => \kartik\daterange\DateRangePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'created_at',
                                    'convertFormat' => true,
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                    'pluginOptions' => $dateRangePickerOptions,
                                    'pluginEvents' => $dateRangePickerEvents,
                                ])
                            ],
                            [
                                'class' => ActionColumn::class,
                                //'template' => '{view} &nbsp; {update}',
                            ],
                        ],
                    ]);

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>