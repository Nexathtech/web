<?php

namespace kodi\backend\controllers;

use Carbon\Carbon;
use kodi\common\models\user\User;
use Yii;
use yii\web\ErrorAction;

/**
 * Class `DashboardController`
 * ===========================
 *
 * This controller is responsible for user authentication.
 */
final class DashboardController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [

            // Error handler
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index', [
            'usersData' => [],
            'subscriptionsData' => [],
        ]);
    }
}
