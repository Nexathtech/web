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
// Note, we do not support skrollr on non-desktop devices
if ($content->alias === 'station' || $content->alias === 'plus') {
    $this->registerCssFile("/styles/site/{$content->alias}.css", [
        'media' => 'only screen and (min-width: 1001px)',
        'data-skrollr-stylesheet' => '',
    ]);
}

$this->title = Yii::t('frontend', $content->title);
$this->registerMetaTag(['name' => 'description', 'content' => $content->meta_description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $content->meta_keywords], 'keywords');
$this->registerJs($content->script);

echo \yii\helpers\Html::csrfMetaTags();
?>

<div class="page-<?= $content->alias; ?>">
    <?= $content->text; ?>
</div>
