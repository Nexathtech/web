<?php

namespace kodi\backend\themes\admire\widgets\grid;

use Yii;

/**
 * Class `GridView`
 * ================
 *
 * This is the customized [[\yii\grid\GridView]] widgets with some UI tweaks.
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->emptyText = $this->render('@app/themes/admire/views/layouts/includes/_no_results');
        $this->summaryOptions = [
            'class' => 'summary m-b-sm',
        ];
        $this->layout = "{summary}\n{items}\n<div class='dataTables_paginate paging_simple_numbers'>{pager}</div>";
        $this->pager = [
            'pageCssClass' => 'paginate_button',
        ];

        parent::init();
    }
}
