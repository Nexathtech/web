<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use kodi\frontend\assets\AppAsset;

AppAsset::register($this);
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
    <a class="logo" href="/"></a>
</div>

<div class="wrap">
    <div class="container">
        <?= $content ?>
    </div>
</div>

<div class="footer"></div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
