<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/**
 * View file for "Update page" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\page\Page $model
 *
 * @see \kodi\backend\controllers\PageController::actionCreate()
 */

$this->title = Yii::t('backend', 'Update page "{title}"', ['title' => Html::encode($model->title)]);
$this->params['description'] = FA::i('file-text') . ' ' . Yii::t('backend', 'Kodi pages');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Page management'),
        'url' => ['/page'],
    ],
    $this->title,
];
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>


