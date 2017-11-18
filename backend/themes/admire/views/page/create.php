<?php

use rmrevin\yii\fontawesome\FA;

/**
 * View file for "Add new page" pages.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\page\Page $model
 *
 * @see \kodi\backend\controllers\PageController::actionCreate()
 */


$this->title = Yii::t('backend', 'Add new page');
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

