<?php

use kodi\backend\themes\admire\assets\ThemeAsset;
use kodi\common\enums\order\OrderType;
use kodi\common\enums\order\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;

/**
 * The view file for the "List orders" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\Order $model
 * @var array $adImages
 *
 * @see \kodi\backend\controllers\OrderController::actionView()
 */

$this->title = Yii::t('backend', 'View order #{id}', ['id' => $model->id]);
$this->params['description'] = FA::i('shopping-cart') . ' ' . Yii::t('backend', 'Kodi orders');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Orders management'),
        'url' => ['/order'],
    ],
    $this->title,
];

$themeUrl = $this->theme->getBaseUrl();
$this->registerCssFile('/css/print-photos.css');
$this->registerJsFile("{$themeUrl}/js/photo-print.js", ['depends' => ThemeAsset::class]);
$theme = $this;
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white">
            <?
                $completeBtn = Html::a(FA::i('check') . Yii::t('backend', 'Complete'), ['mark', 'id' => $model->id], [
                    'class' => 'btn btn-success btn-post pull-right ml-1',
                    'data-data' => '{"status": "' . Status::COMPLETED . '"}',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('backend', 'Mark as {status}', ['status' => Status::COMPLETED]),
                ]);

                echo Yii::t('backend', 'Order #{id}', ['id' => $model->id]);
                if ($model->status === Status::PENDING || $model->status === Status::WAITING) {
                    echo $completeBtn;
                    echo Html::a(FA::i('send') . Yii::t('backend', 'Shipped'), ['mark', 'id' => $model->id], [
                        'class' => 'btn btn-primary btn-post pull-right ml-1',
                        'data-data' => '{"status": "' . Status::SHIPPED . '"}',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('backend', 'Mark as {status}', ['status' => Status::SHIPPED]),
                    ]);
                    echo Html::a(FA::i('eye') . Yii::t('backend', 'Reviewed'), ['mark', 'id' => $model->id], [
                        'class' => 'btn btn-default btn-post pull-right ml-1',
                        'data-data' => '{"status": "' . Status::REVIEWED . '"}',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('backend', 'Mark as {status}', ['status' => Status::REVIEWED]),
                    ]);
                    echo Html::a(FA::i('times') . Yii::t('backend', 'Cancel'), ['mark', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-post pull-right',
                        'data-data' => '{"status": "' . Status::CANCELED . '"}',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('backend', 'Mark as {status}', ['status' => Status::CANCELED]),
                    ]);
                }

                if ($model->status === Status::REVIEWED) {
                    echo $completeBtn;
                    echo Html::a(FA::i('send') . Yii::t('backend', 'Shipped'), ['mark', 'id' => $model->id], [
                        'class' => 'btn btn-primary btn-post pull-right ml-1',
                        'data-data' => '{"status": "' . Status::SHIPPED . '"}',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('backend', 'Mark as {status}', ['status' => Status::SHIPPED]),
                    ]);
                    echo Html::a(FA::i('times') . Yii::t('backend', 'Cancel'), ['mark', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-post pull-right',
                        'data-data' => '{"status": "' . Status::CANCELED . '"}',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('backend', 'Mark as {status}', ['status' => Status::CANCELED]),
                    ]);
                }

                if ($model->status === Status::SHIPPED) {
                    echo $completeBtn;
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
                            'type',
                            'email',
                            'name',
                            'surname',
                            'address',
                            'postcode',
                            'city',
                            'state',
                            'country',
                            'company',
                            'location_latitude',
                            'location_longitude',
                            'color',
                            'quantity',
                            'total',
                            'payment_type',
                            [
                                'label' => $model->getAttributeLabel('status'),
                                'format' => 'html',
                                'value' => function($data) {
                                    $status = $data->status;
                                    $className = 'label label-default';
                                    if ($data->status === Status::PENDING) {
                                        $className = 'label label-danger';
                                    }
                                    if ($data->status === Status::WAITING) {
                                        $className = 'label label-warning';
                                        $status = Yii::t('backend', 'Waiting for payment from customer');
                                    }
                                    if ($data->status === Status::COMPLETED) {
                                        $className = 'label label-success';
                                    }

                                    return Html::tag('span', $status, ['class' => $className]);
                                }
                            ],
                            [
                                'label' => Yii::t('backend', 'Action ID'),
                                'format' => 'html',
                                'value' => function($data) {
                                    if (!empty($data->order_data)) {
                                        $orderData = Json::decode($data->order_data);
                                        if (!empty($orderData['action_id'])) {
                                            return Html::a($orderData['action_id'], ['/action/view', 'id' => $orderData['action_id']]);
                                        }
                                    }

                                    return null;
                                }
                            ],
                            [
                                'label' => Yii::t('frontend', 'Photos'),
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'photos-row'],
                                'value' => function($data) use ($adImages, $theme) {
                                    return $theme->render('_photos', [
                                        'data' => $data,
                                        'adImages' => $adImages,
                                    ]);
                                },
                                'visible' => ($model->type === OrderType::PHOTO),
                            ],
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
