<?php

use rmrevin\yii\fontawesome\FA;

/**
 * View file for "Update order" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\Order $model
 *
 * @see \kodi\backend\controllers\OrderController::actionUpdate()
 */

$this->title = Yii::t('backend', 'Update order #{id}', ['id' => $model->id]);
$this->params['description'] = FA::i('shopping-cart') . ' ' . Yii::t('backend', 'Kodi orders');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Orders management'),
        'url' => ['/order'],
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

