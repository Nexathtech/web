<?php
namespace kodi\frontend\controllers;

use kodi\common\enums\Status;
use kodi\common\models\page\Page;
use kodi\frontend\models\forms\SubscribeForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage with subscribe form.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $page = Page::find()->where(['alias' => 'homepage', 'status' => Status::ACTIVE])->one();

        return $this->render('index', ['content' => $page]);
    }

    /**
     * Displays a page with slug given.
     *
     * @param string $slug
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        // Do not allow homepage to show on page different from home page
        if ($slug !== 'homepage') {
            $page = Page::find()->where(['alias' => $slug, 'status' => Status::ACTIVE])->one();
        }

        if (empty($page)) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'content' => $page,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
