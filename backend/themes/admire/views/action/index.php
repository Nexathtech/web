<?php

use kartik\daterange\DateRangePicker;
use kodi\backend\themes\admire\widgets\grid\ActionColumn;
use kodi\backend\themes\admire\widgets\grid\GridView;
use kodi\common\enums\action\Status;
use kodi\common\enums\action\Type;
use kodi\common\enums\DeviceType;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\FormatConverter;
use yii\helpers\Html;

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
                            [
                                'attribute' => 'user.profile.name',
                                'label' => Yii::t('backend', 'Initiator'),
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $fullName = $data->user->profile->getFullName();
                                    $name = (!empty($fullName)) ? $fullName : $data->user->email;
                                    if (empty($data->user->profile->surname)) {
                                        $name = "{$fullName} ({$data->user->email})";
                                    }
                                    $id = $data->user->id;
                                    return Html::a(Html::encode($name), ['/user/view', 'id' => $id]);
                                }
                            ],
                            [
                                'attribute' => 'device_id',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $id = $data->device_id;
                                    return Html::a(Html::encode($id), ['/device/view', 'id' => $id]);
                                },
                            ],
                            [
                                'attribute' => 'action_type',
                                'format' => 'raw',
                                'filter' => Type::listData(),
                                'value' => function ($data) {
                                    return Type::listData()[$data->action_type];
                                }
                            ],
                            [
                                'attribute' => 'device_type',
                                'format' => 'raw',
                                'filter' => DeviceType::listData(),
                            ],
                            'promo_code',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => Status::listData(),
                                'value' => function ($data) {
                                    return Html::tag('span', $data->status, [
                                        'class' => ($data->status == Status::NEW) ? 'label label-success' : 'label label-default'
                                    ]);
                                }
                            ],
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