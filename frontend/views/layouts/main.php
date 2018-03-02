<?php
use Carbon\Carbon;
use kodi\frontend\widgets\LanguageSwitcher;
use yii\helpers\Html;
use kodi\frontend\assets\AppAsset;
use yii\helpers\Url;
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
    <title><?= Html::encode($this->title); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <meta content="<?= Yii::$app->name; ?>" property="og:site_name">
    <meta content="website" property="og:type">
    <meta content="<?= $this->title; ?>" property="og:title">
    <meta content="<?= Url::to('/images/kodi.png', true); ?>" property="og:image">
    <meta content="<?= Url::home(true); ?>" property="og:url">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-89215051-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-89215051-1');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-TJ57KWH');</script>
    <!-- End Google Tag Manager -->

</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJ57KWH"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php $this->beginBody() ?>
<?= $this->render('includes/_flash_messages') ?>

<div class="header">
    <?= LanguageSwitcher::widget(); ?>
    <a class="logo" href="/"></a>
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
        <a href="/about#contact">Contacts</a>
        <a href="/press">Press</a>
        <a href="/privacy-policy">Privacy policy</a>
        <a href="/terms-and-conditions">T&C</a><br>
    </div>
    <div class="footer-copyright">&copy; <?= Carbon::now()->year; ?> Kodi LLC</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
