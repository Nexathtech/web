<?php

namespace kodi\backend\themes\admire\widgets\grid;

use omnilight\assets\SweetAlertAsset;
use rmrevin\yii\fontawesome\FA;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JqueryAsset;

/**
 * Class `ActionColumn`
 * ====================
 *
 * This is the customized [[\yii\grid\ActionColumn]] widget with some UI tweaks.
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @inheritdoc
     */
    public $template = '{view} &nbsp; {update} &nbsp; {delete}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->registerAssets();
        $this->header = Yii::t('backend', 'Actions');
        $this->buttons = ArrayHelper::merge([
            'view' =>
                function ($url) {
                    return Html::a(FA::i('eye', ['class' => 'text-success']), $url, [
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('backend', 'View'),
                    ]);
                },
            'update' =>
                function ($url) {
                    return Html::a(FA::i('pencil', ['class' => 'text-warning']), $url, [
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('backend', 'Edit'),
                    ]);
                },
            'delete' =>
                function ($url) {
                    return Html::a(FA::i('trash', ['class' => 'text-danger']), $url, [
                        'class' => 'grid-view-confirm',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('backend', 'Delete'),
                    ]);
                },
        ], $this->buttons);

        parent::init();
    }

    /**
     * Registers required assets.
     */
    public function registerAssets()
    {
        $this->grid->view->registerJsFile(Yii::getAlias('@web/themes/admire/js/widgets/grid/action-column.js'), [
            'depends' => [
                SweetAlertAsset::class,
                JqueryAsset::class,
            ]
        ]);
    }
}
