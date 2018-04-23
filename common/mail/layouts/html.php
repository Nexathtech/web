<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */

$homeUrl = str_replace('api.', '', Url::to(['/'], true));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <style type="text/css">
      @font-face {
        font-family: 'HKNova';
        src: url('<?= $homeUrl ?>fonts/HKNova-Medium.eot');
        src: url('<?= $homeUrl ?>fonts/HKNova-Medium.eot?#iefix') format('embedded-opentype'),
          url('<?= $homeUrl ?>fonts/HKNova-Medium.woff2') format('woff2'),
          url('<?= $homeUrl ?>fonts/HKNova-Medium.woff') format('woff'),
          url('<?= $homeUrl ?>fonts/HKNova-Medium.ttf')  format('truetype');
      }
      @font-face {
        font-family: 'Alte DIN';
        src: url('<?= $homeUrl ?>fonts/AlteDIN.eot');
        src: url('<?= $homeUrl ?>fonts/AlteDIN.eot?#iefix') format('embedded-opentype'),
          url('<?= $homeUrl ?>fonts/AlteDIN.woff') format('woff'),
          url('<?= $homeUrl ?>fonts/AlteDIN.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
      }
      body {
        background: #fff;
        font-family: 'HKNova', 'sans-serif';
      }
    </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <?= $content ?>

    <div class="footer" style="width: 100%;height: 130px;background: url(<?= $homeUrl ?>/styles/img/footer-waves.png) repeat-x;"></div>
    <div style="margin-top: 20px; text-align: center; font-size: 11px; color: #606060;">
        You received this email because you have been registered on <a href="<?= $homeUrl ?>">meetkodi.com</a>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
