<?php

use kodi\backend\themes\admire\assets\ThemeAsset;
use kodi\common\enums\order\OrderType;
use kodi\common\enums\order\Status;
use kodi\common\models\Action;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
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
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white">
                <?= Yii::t('backend', 'Order #{id}', ['id' => $model->id]) ?>
            </div>
            <div class="card-block m-t-35">
                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'type',
                            'name',
                            'surname',
                            'email',
                            'company',
                            'country',
                            'city',
                            'state',
                            'address',
                            'postcode',
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
                                'label' => Yii::t('frontend', 'Photos'),
                                'format' => 'html',
                                'value' => function($data) use ($adImages) {
                                    /* @var $data \kodi\common\models\Order */
                                    $html = '';
                                    if (!empty($data->order_data)) {
                                        $orderData = Json::decode($data->order_data);
                                        if (!empty($orderData['action_id'])) {
                                            $action = Action::findOne(['id' => $orderData['action_id']]);
                                            if (!empty($action)) {
                                                $actionData = Json::decode($action->data);
                                                $images = ArrayHelper::getValue($actionData, 'images', []);
                                                foreach ($images as $image) {
                                                    $img = Html::img($image['path'], ['class' => 'p-img p-img-original']);
                                                    for ($i=0; $i<$image['count']; $i++) {
                                                        $html .= Html::tag('div', $img, ['class' => 'p-item']);
                                                    }
                                                }

                                                // Now add advertisement image$adImages
                                                $img = Html::img($adImages[0]['image'], ['class' => 'p-img ad-image']);
                                                $html .= Html::tag('div', $img, ['class' => 'p-item']);
                                            }
                                        }
                                    }

                                    if (!empty($html)) {
                                        $html = Html::tag('div', $html, ['class' => 'print-block']);
                                        $aTitle = FA::i('print') . ' Print photos';
                                        $html .= Html::a($aTitle, '#', ['class' => 'btn btn-primary my-1 print-btn']);
                                        $html .= Html::a(Yii::t('backend', 'More photos...'), '#', ['class' => 'btn btn-info more-photos-btn']);
                                        $html .= Html::beginTag('div', ['class' => 'more-photos']);
                                        $imageTypes = [];
                                        foreach ($adImages as $img) {
                                            $iType = strtolower($img['type']);
                                            if (!in_array($iType, $imageTypes)) {
                                                array_push($imageTypes, $iType);
                                            }
                                        }

                                        $html .= Html::beginTag('div', ['class' => 'i-filter']);
                                        foreach ($imageTypes as $iType) {
                                            $html .= Html::tag('span', $iType);
                                        }
                                        $html .= Html::endTag('div');

                                        foreach ($adImages as $i => $img) {
                                            $imgClass = strtolower($img['type']);
                                            if ($i === 0) { $imgClass .= ' active'; }
                                            $html .= Html::img($img['image'], ['class' => $imgClass]);
                                        }

                                        $html .= Html::endTag('div');
                                    }

                                    return $html;
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
