<?php
namespace kodi\frontend\controllers;

use Carbon\Carbon;
use kodi\common\enums\Status;
use kodi\common\models\page\Page;
use Yii;
use yii\filters\ContentNegotiator;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class `SitemapController`
 * =========================
 *
 * This controller is responsible for rendering site map.
 */
class SitemapController extends Controller
{
    /**
     * @var array $urls to be added to the sitemap
     */
    private $urls = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            // Negotiator filter
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['index'],
                'formats' => [
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
        ];
    }

    /**
     * Displays main page.
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        //if (!$sitemap = Yii::$app->cache->get('sitemap')) {

            // Add static pages (like homepage, about etc.)
            $this->addStaticPages();

            // Add content pages
            $pages = Page::findAll(['status' => Status::ACTIVE]);
            foreach ($pages as $page) {
                $link = Url::to(["/{$page->alias}"], true);
                array_push($this->urls, [
                    'loc' => $link,
                    'lastmod' => Carbon::createFromFormat('Y-m-d H:i:s', $page->updated_at)->format('Y-m-d'),
                    'changefreq' => 'weekly',
                    'priority' => 0.8,
                ]);
            }

            $sitemap = $this->renderPartial('index', ['urls' => $this->urls]);
            Yii::$app->cache->set('sitemap', $sitemap, 3600*12);
        //}

        echo $sitemap;
    }

    /**
     * Adds static pages to sitemap urls
     * Pages that are not stored in DB
     */
    protected function addStaticPages()
    {
        // Homepage, About, Press
        $staticUrls = ['/', '/about', '/press'];
        foreach ($staticUrls as $url) {
            array_push($this->urls, [
                'loc' => Url::to($url, true),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => 0.8,
            ]);
        }
    }
}
