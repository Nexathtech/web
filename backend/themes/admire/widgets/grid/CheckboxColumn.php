<?php

namespace kodi\backend\themes\admire\widgets\grid;

use omnilight\assets\SweetAlertAsset;
use Yii;
use yii\web\JqueryAsset;

/**
 * Class `CheckboxColumn`
 * ======================
 *
 * This is the customized [[\yii\grid\ActionColumn]] widget with some UI tweaks.
 */
class CheckboxColumn extends \yii\grid\CheckboxColumn
{
    public $buttonClass = 'checked-action';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * Registers required assets.
     */
    public function registerAssets()
    {
        $this->grid->view->registerJsFile(Yii::getAlias('@web/themes/admire/js/widgets/grid/checkbox-column.js'), [
            'depends' => [
                SweetAlertAsset::class,
                JqueryAsset::class,
            ]
        ]);
        $this->grid->view->registerJs("
            initSelection('{$this->grid->options['id']}', '{$this->buttonClass}', '{$this->name}');
        ");
    }
}
