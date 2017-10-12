<?php

use kartik\daterange\DateRangePicker;
use kodi\backend\themes\admire\widgets\grid\ActionColumn;
use kodi\backend\themes\admire\widgets\grid\GridView;
use kodi\common\enums\PromoCodeStatus;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\FormatConverter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * The view file for the "List actions" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\ActionSearch $searchModel
 * @var \yii\data\ActiveDataProvider $dataProvider
 *
 * @see \kodi\backend\controllers\ActionController::actionIndex()
 */

$this->title = Yii::t('backend', 'Actions management');
$this->params['description'] = FA::i('bullseye') . ' ' . Yii::t('backend', 'Actions');
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
                <?= Yii::t('backend', 'Actions') ?>
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
                            'user_id',
                            'type',
                            'agent',
                            'promo_code',
                            'status',
                            [
                                'attribute' => 'created_at',
                                'filter' => DateRangePicker::widget([
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
                                'template' => '<div class="text-center">{view} &nbsp; {delete}</div>',
                            ],
                        ],
                    ]);

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>