<?php

/* @var $this \yii\web\View */
/* @var $content string */

use kodi\backend\themes\admire\assets\ThemeAsset;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

ThemeAsset::register($this);
$user = Yii::$app->user->identity;
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<!-- Display flash messages -->
<?= $this->render('includes/_flash_messages') ?>

<div class="bg-dark" id="wrap">
    <div id="top">
        <?= $this->render('includes/_nav', ['user' => $user]); ?>
    </div>

    <div class="wrapper">
        <div id="left">
            <?= $this->render('includes/_menu', ['user' => $user]); ?>
        </div>

        <div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-sm-4">
                        <h4 class="nav_top_align"><?= ArrayHelper::getValue($this->params, 'description'); ?></h4>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12">
                        <?= Breadcrumbs::widget([
                            'tag' => 'ol',
                            'options' => ['class' => 'breadcrumb float-xs-right  nav_breadcrumb_top_align'],
                            'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                            'activeItemTemplate' => "<li class='active breadcrumb-item'>{link}</li>\n",
                            'homeLink' => [
                                'label' => FA::i('home') . ' ' . Yii::t('backend', 'Home'),
                                'encode' => false,
                                'url' => Yii::$app->homeUrl,
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                    </div>
                </div>
            </header>

            <?= $content ?>

        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
