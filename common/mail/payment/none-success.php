<?php

use yii\helpers\Html;

/**
 * Email template for wire transfer order
 *
 * $this yii\web\View
 * @var $data array
 */

?>

<div>
    <h1 class="text-center"><?= Yii::t('frontend', 'Thanks for using Kodi!'); ?></h1>
    <p>
        <?= Yii::t('frontend', 'Thanks for ordering Kodi polaroid photos!'); ?><br>
        <?= Yii::t('frontend', 'We will send your polaroid photo as soon as possible.'); ?>
    </p>
</div>
