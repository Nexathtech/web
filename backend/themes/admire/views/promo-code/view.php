<?php

use kodi\common\enums\promocode\Status as PromoCodeStatus;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * The view file for the "List promo codes" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\promocode\PromoCode $model
 *
 * @see \kodi\backend\controllers\PromoCodeController::actionView()
 */

$this->title = Yii::t('backend', 'View promo code "{name}"', ['name' => Html::encode($model->code)]);
$this->params['description'] = FA::i('credit-card-alt') . ' ' . Yii::t('backend', 'Promo codes');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Promo codes management'),
        'url' => ['/promo-code'],
    ],
    $this->title,
];
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white"><?= Yii::t('backend', 'Promo codes') ?></div>
            <div class="card-block m-t-35">
                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'identity_id',
                                'label' => Yii::t('backend', 'Social user'),
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if (!empty($model->identity_id)) {
                                        return Html::a($model->identity->name, $model->identity->profile_url, ['target' => '_blank']);
                                    }
                                }
                            ],
                            'code',
                            'description',
                            'data',
                            'type',
                            [
                                'label' => $model->getAttributeLabel('status'),
                                'format' => 'html',
                                'value' => Html::tag('span', $model->status, [
                                    'class' => ($model->status == PromoCodeStatus::NEW) ? 'label label-success' : 'label label-default',
                                ]),
                            ],
                            'created_at:datetime',
                            'expires_at:datetime',
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
