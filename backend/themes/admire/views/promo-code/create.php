<?php

use rmrevin\yii\fontawesome\FA;

/**
 * View file for "Add new promo code" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\PromoCode $model
 *
 * @see \kodi\backend\controllers\PromoCodeController::actionCreate()
 */


$this->title = Yii::t('backend', 'Add new promo code');
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
            <?= $this->render('_form', ['model' => $model]); ?>
        </div>
    </div>
</div>
