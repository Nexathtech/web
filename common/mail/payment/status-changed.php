<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Email template for wire transfer order
 *
 * $this yii\web\View
 * @var $data array
 */

$homeUrl = str_replace('api.', '', Url::home(true));
$homeUrl = str_replace('backend.', '', Url::home(true));
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
