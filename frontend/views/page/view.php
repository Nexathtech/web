<?

use yii\helpers\Html;

/**
 * The view file for the "page/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $content \kodi\common\models\page\Page content
 * @see \kodi\frontend\controllers\PageController::actionView()
 */

$this->title = Yii::t('frontend', $content->title);
$this->registerMetaTag(['name' => 'description', 'content' => $content->meta_description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $content->meta_keywords], 'keywords');
$this->registerJs($content->script);

$br = Html::tag('span', '', ['class' => 'br']);
?>

<div class="page-<?= $content->alias; ?> page-regular">
    <div class="page-title">
        <? if ($content->alias === 'service-level-agreement'): ?>
            <a href="/purchase-agreement" class="passive">Purchase<?= $br ?>agreement</a>
            <div class="title-delimiter"></div>
        <? endif; ?>
        <? if ($content->alias === 'privacy-policy'): ?>
            <a href="/terms-and-conditions" class="passive">Terms<?= $br ?>&<?= $br ?>conditions</a>
            <div class="title-delimiter"></div>
        <? endif; ?>

        <a href="/<?= $content->alias; ?>"><?= str_replace(' ', $br, $content->title); ?></a>

        <? if ($content->alias === 'purchase-agreement'): ?>
            <div class="title-delimiter"></div>
            <a href="/service-level-agreement" class="passive">Service<?= $br ?>level<?= $br ?>agreement</a>
        <? endif; ?>
        <? if ($content->alias === 'terms-and-conditions'): ?>
            <div class="title-delimiter"></div>
            <a href="/privacy-policy" class="passive">Privacy<?= $br ?>policy</a>
        <? endif; ?>
    </div>
    <div class="page-content">
        <?= $content->text; ?>
    </div>
    <a class="page-close" href="/"></a>
</div>
