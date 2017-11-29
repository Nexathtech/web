<?php

namespace kodi\frontend\controllers;

use kodi\common\enums\Status;
use kodi\common\models\page\Page;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class `PageController`
 * ======================
 *
 * This controller is responsible for rendering custom application pages.
 */
class PageController extends Controller
{
    /**
     * Displays a static page with slug given.
     *
     * @param string $slug
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        // Do not allow homepage to show on page different from home page
        if ($slug !== 'homepage' && $slug !== 'about') {
            $page = Page::find()->where(['alias' => $slug, 'status' => Status::ACTIVE])->one();
        }
        if (empty($page)) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'content' => $page,
        ]);
    }
}
