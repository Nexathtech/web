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
    <h1 class="text-center"><?= Yii::t('frontend', 'Dear customer'); ?>,</h1>
    <p>
        <?= Yii::t('frontend', 'The status of your order #{id} has been changed to {status}', [
            'id' => $data['id'],
            'status' => $data['status'],
        ]); ?>
    </p>
</div>
