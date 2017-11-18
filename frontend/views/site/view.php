<?
use kodi\frontend\assets\SkrollrAsset;

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $content \kodi\common\models\page\Page content
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */


SkrollrAsset::register($this);

$this->title = Yii::t('frontend', $content->title);
//$this->registerMetaTag(['name' => 'description', 'content' => $content->meta_description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $content->meta_keywords], 'keywords');
$this->registerJs($content->script);
?>

<div class="page-<?= $content->alias; ?>">
    <?= $content->text; ?>
</div>
