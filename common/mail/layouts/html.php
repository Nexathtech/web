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
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div style="padding: 20px;background: #ffce46;">
        <a href="<?= $homeUrl; ?>" class="logo" style="display: block;width: 100px;height: 48px;margin: 0 auto;background: url(<?= $homeUrl; ?>/styles/img/logo-black.png) no-repeat;background-size: 100%;"></a>
    </div>

    <div class="content" style="padding: 50px;font-size: 16px;color: #45433d;">
        <div class="content-inner">
            <?= $content ?>
        </div>
    </div>

    <?= $this->render('includes/_social_links', ['homeUrl' => $homeUrl]) ?>
    <div class="footer" style="width: 100%;height: 110px;background: url(<?= $homeUrl ?>/styles/img/footer-waves2.png) repeat-x;"></div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
