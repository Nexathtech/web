<?php

use kodi\common\enums\Status;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Html;
use yii\widgets\DetailView;

/**
 * The view file for the "List pages" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\page\Page $model
 *
 * @see \kodi\backend\controllers\PageController::actionView()
 */

$this->title = Yii::t('backend', 'View page "{title}"', ['title' => Html::encode($model->title)]);
$this->params['description'] = FA::i('user') . ' ' . Yii::t('backend', 'Kodi pages');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Page management'),
        'url' => ['/page'],
    ],
    $this->title,
];
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white"><?= Yii::t('backend', 'Devices list') ?></div>
            <div class="card-block m-t-35">
                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'title',
                            'alias',
                            'text',
                            [
                                'label' => $model->getAttributeLabel('status'),
                                'format' => 'html',
                                'value' => Html::tag('span', $model->status, [
                                    'class' => ($model->status == Status::ACTIVE) ? 'label label-success' : 'label label-default',
                                ]),
                            ],
                            'meta_description',
                            'meta_keywords',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>