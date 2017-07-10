<?

use kodi\backend\themes\admire\assets\ThemeAsset;
use yii\helpers\Html;

/**
 * External HTML layout.
 *
 * @var \yii\web\View $this Current view instance.
 * @var string $content Page Content.
 */

ThemeAsset::register($this);
?>
<? $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <? $this->head(); ?>
</head>
<body class="gray-bg">
    <? $this->beginBody(); ?>
    <!-- Display flash messages -->
    <?= $this->render('includes/_flash_messages') ?>

    <!-- Page contents -->
    <?= $content ?>

    <? $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
