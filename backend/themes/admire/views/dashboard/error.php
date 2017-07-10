<?php

use rmrevin\yii\fontawesome\FA;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\HttpException;

/**
 * The view file for the "system/error" action.
 *
 * @var  \yii\web\View $this
 * @var  string $name
 * @var  string $message
 * @var  Exception|HttpException $exception
 */

$this->title = $name;
$this->params['description'] = FA::i('warning') . ' ' . Yii::t('backend', 'Error');
$errorCode =
    ($exception instanceof HttpException)
        ? $exception->statusCode
        : $exception->getCode();
?>

<div class="container text-center m-t-35">
    <h1><?= $errorCode ?></h1>
    <h3 class="font-bold">
        <?= Html::encode($this->title) ?>
    </h3>

    <div class="error-desc">
        <?= Html::encode($message) ?>
        <br/>
        <a href="<?= Url::to(['/dashboard']) ?>" class="btn btn-primary m-t">
            <?= Yii::t('backend', 'Return to dashboard') ?>
        </a>
    </div>
</div>