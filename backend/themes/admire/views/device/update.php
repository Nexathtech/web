<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/**
 * View file for "Update device" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\device\Device $model
 *
 * @see \kodi\backend\controllers\DeviceController::actionUpdate()
 */

$this->title = Yii::t('backend', 'Update device "{name}"', ['name' => Html::encode($model->name)]);
$this->params['description'] = FA::i('android') . ' ' . Yii::t('backend', 'Kodi devices');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'User management'),
        'url' => ['/user'],
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

