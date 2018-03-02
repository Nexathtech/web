<?php

/**
 * The view file for the "sitemap/index" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var array $urls
 * @see \kodi\frontend\controllers\SitemapController::actionIndex()
 */

$this->title = Yii::t('frontend', 'Sitemap');

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <? foreach ($urls as $url): ?>
    <url>
        <loc><?= $url['loc']; ?></loc>
        <lastmod><?= $url['lastmod']; ?></lastmod>
        <changefreq><?= $url['changefreq']; ?></changefreq>
        <priority><?= $url['priority']; ?></priority>
    </url>
    <? endforeach; ?>
</urlset>


