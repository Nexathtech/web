<?php
use kodi\frontend\assets\SkrollrAsset;

/**
 * The view file for the "site/index" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $content \kodi\common\models\page\Page content
 * @see \kodi\frontend\controllers\SiteController::actionIndex()
 */

SkrollrAsset::register($this);

$this->title = 'Kodi';
$this->registerJs($content->script);
$this->registerCss(".footer {display: none;}");
?>

<div class="page-home">
    <?= $content->text; ?>
</div>
