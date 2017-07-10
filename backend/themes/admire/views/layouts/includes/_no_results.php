<?php

use rmrevin\yii\fontawesome\FA;

/**
 * Partial view file for "No Results" in data provider.
 *
 * @var $this \yii\web\View
 */

?>

<div class="text-center">
    <h1 class="text-muted m-b-md">
        <?= FA::icon('search') ?>
    </h1>
    <h3 class="text-muted">
        <?= Yii::t('backend', 'No results found!') ?>
    </h3>
</div>