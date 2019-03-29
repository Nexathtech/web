<?php

use rmrevin\yii\fontawesome\FA;

/**
 * View file for "Add new event" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\event\Event $model
 *
 * @see \kodi\backend\controllers\EventController::actionCreate()
 */


$this->title = Yii::t('backend', 'Add new event');
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
