<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/**
 * View file for "Update image" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\AdImage $model
 *
 * @see \kodi\backend\controllers\AdImageController::actionUpdate()
 */

$this->title = Yii::t('backend', 'Update image "{id}"', ['id' => Html::encode($model->id)]);
$this->params['description'] = FA::i('camera-retro') . ' ' . Yii::t('backend', 'Advertisement images');
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

