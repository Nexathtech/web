<?php

namespace kodi\frontend\routes;

use kodi\common\enums\Status;
use kodi\common\models\page\Page;
use yii\web\UrlRule;

/**
 * This class handle page rule. When page not found by giving slug returns false
 */
class SiteRule extends UrlRule
{
    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (empty($pathInfo)) {
            return false;
        }

        $slugs = explode('/', $pathInfo);
        if ((count($slugs) > 1)) {
            return false;
        }
        $page = Page::find()->where(['alias' => $slugs[0], 'status' => Status::ACTIVE])->one();
        if (empty($page)) {
            return false;
        }

        return [$this->route, ['slug' => $slugs[0]]];
    }
}
