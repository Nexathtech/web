<?php

use rmrevin\yii\fontawesome\FA;

/**
 * View file for "Add new image" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\AdImage $model
 *
 * @see \kodi\backend\controllers\AdImageController::actionCreate()
 */


$this->title = Yii::t('backend', 'Add new ad image');
$this->params['description'] = FA::i('camera-retro') . ' ' . Yii::t('backend', 'Kodi ad image');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Advertisement images management'),
        'url' => ['/ad-image'],
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
