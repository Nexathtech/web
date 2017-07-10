<?php

namespace kodi\backend\controllers;

use Yii;

/**
 * Class `GeneralController`
 * =========================
 *
 * This controller is responsible for representing common server information.
 */
final class GeneralController extends BaseController
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'server-info';

    /**
     * Shows server configuration information.
     *
     * @return mixed
     */
    public function actionServerInfo()
    {
        return $this->render('server-info');
    }
}
