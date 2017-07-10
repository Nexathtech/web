<?php

use rmrevin\yii\fontawesome\FA;

/**
 * View file for "Add new device" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\device\Device $model
 *
 * @see \kodi\backend\controllers\DeviceController::actionCreate()
 */


$this->title = Yii::t('backend', 'Add new device');
$this->params['description'] = FA::i('android') . ' ' . Yii::t('backend', 'Kodi devices');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Device management'),
        'url' => ['/device'],
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
