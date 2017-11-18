<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use kodi\frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$slug = Yii::$app->request->get('slug');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Display flash messages -->
<?= $this->render('includes/_flash_messages') ?>

<div class="header">
    <a class="btn-plus <?= $slug === 'about' ? 'active' : '' ?>" href="<?= $slug === 'about' ? '/' : '/about' ?>" title="About us"></a>
    <a class="logo" href="/"></a>
    <div class="top-nav" id="top-nav">
        <a href="/station" class="<?= $slug === 'station' ? 'active' : '' ?>">kodi station</a>
        <a href="/printing" class="<?= $slug === 'printing' ? 'active' : '' ?>">kodi printing</a>
        <a href="/plus" class="<?= $slug === 'plus' ? 'active' : '' ?>">kodi plus</a>
        <a href="/koders" class="<?= $slug === 'koders' ? 'active' : '' ?>">koders</a>
        <a href="javascript:void(0);" class="top-nav-icon" onclick="openTopNav()">&#9776;</a>
    </div>
</div>

<?= $content ?>

<div class="footer">
    <div class="f-left">
        <a href="#">sitemap</a>
        <a href="#">info</a>
        <a href="#">jobs opportunity</a>
        <a href="#">events</a>
    </div>
    <div class="f-right">
        <a href="#">terms and conditions</a>
        <a href="#">contact</a>
        <a href="#">ads with kodi</a>
        <a href="#">kodi accessories</a>
        <a href="#">privacy policy</a>
    </div>
    <div class="clear"></div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
