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
        <? if (!$data['is_wire_payment']): ?>
            <?= Yii::t('frontend', 'We will process your order as soon as possible.'); ?>
        <? endif; ?>
    </p>
    <? if ($data['is_wire_payment']): ?>
        <?= $this->render('_wire-details', ['data' => $data]); ?>
    <? endif; ?>
</div>
