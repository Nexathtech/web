<?php
use Carbon\Carbon;
use yii\helpers\Html;
use kodi\frontend\assets\AppAsset;
use yii\web\View;

/* @var $this View */
/* @var $content string */


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
<?= $this->render('includes/_flash_messages') ?>

<div class="header">
    <a class="btn-plus <?= $slug === 'about' ? 'active' : '' ?>" href="<?= $slug === 'about' ? '/' : '/about' ?>" title="About us"></a>
    <a class="logo" href="/"></a>
    <div class="top-nav" id="top-nav">
        <a href="/station" class="<?= $slug === 'station' ? 'active' : '' ?>">station</a>
        <a href="/printing" class="<?= $slug === 'printing' ? 'active' : '' ?>">kodi printing</a>
        <a href="/plus" class="<?= $slug === 'plus' ? 'active' : '' ?>">plus</a>
        <a href="/koders" class="<?= $slug === 'koders' ? 'active' : '' ?>">koders</a>
        <a href="/about" class="nav-about <?= $slug === 'about' ? 'active' : '' ?>">about</a>
        <a href="javascript:void(0);" class="top-nav-icon" onclick="openTopNav()">&#9776;</a>
    </div>
    <a class="pre-order-btn" href="/order"><?= Yii::t('frontend', 'pre-order'); ?></a>
</div>

<?= $content ?>

<div class="cookie-message">
    <div class="c-m-title"><?= Yii::t('frontend', 'this website eats cookies'); ?></div>
    <div class="c-m-text"><?= Yii::t('frontend', 'to ensure you get the best experience on our website'); ?></div>
    <div class="c-m-close"></div>
</div>
<div class="footer">
    <div class="social-icons">
        <a href="https://www.facebook.com/meetkodi" class="s-i-fk" target="_blank"></a>
        <a href="https://www.instagram.com/meetkodi/" class="s-i-im" target="_blank"></a>
        <a href="https://www.youtube.com/channel/UCaXsr3XpyHqwOXHGXan5dRw" class="s-i-yb" target="_blank"></a>
        <a href="https://www.linkedin.com/company/meetkodi" class="s-i-ln" target="_blank"></a>
        <a href="https://twitter.com/meetkodi" class="s-i-tw" target="_blank"></a>
        <a href="https://medium.com/@meetkodi" class="s-i-md" target="_blank"></a>
    </div>
    <div class="footer-links">
        <a href="https://medium.com/@meetkodi" target="_blank">Blog</a>
        <a href="/about">About</a>
        <a href="/about#contact">Contacts</a>
        <a href="/press">Press</a>
        <a href="/privacy-policy">Privacy policy</a>
        <a href="/terms-and-conditions">T&C</a><br>
        <a href="/purchase-agreement">Purchase agreement</a>
        <a href="/service-level-agreement">Service level agreement</a>
    </div>
    <div class="footer-copyright">&copy; <?= Carbon::now()->year; ?> Kodi LLC</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
