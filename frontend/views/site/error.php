<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="page-error page-regular">
    <div class="page-title">
        <?= Html::encode($this->title) ?>
        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
    </div>

    <div class="page-content">
        <p>The error occurred while the Web server was processing your request.</p>
        <p>Please contact us if you think this is a server error. Thank you.</p>
    </div>

    <a class="page-close" href="/"></a>

</div>
