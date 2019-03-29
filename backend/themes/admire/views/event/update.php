<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/**
 * View file for "Update event" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\event\Event $model
 *
 * @see \kodi\backend\controllers\EventController::actionUpdate()
 */

$this->title = Yii::t('backend', 'Update event "{name}"', ['name' => Html::encode($model->title)]);
$this->params['description'] = FA::i('flag') . ' ' . Yii::t('backend', 'Kodi events');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Events management'),
        'url' => ['/event'],
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

