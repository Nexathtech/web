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
$action = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title); ?> | MeetKodi</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>

    <?= $this->render('includes/_external_scripts') ?>
</head>

<body>
<? if (YII_ENV_PROD): ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJ57KWH"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<? endif; ?>

<?php $this->beginBody() ?>
<?= $this->render('includes/_flash_messages') ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
