<?php

namespace kodi\backend\controllers;

use Carbon\Carbon;
use kodi\common\enums\action\Type;
use kodi\common\enums\user\Status;
use kodi\common\models\Action;
use kodi\common\models\device\Device;
use kodi\common\models\Order;
use kodi\common\models\user\User;
use yii\db\Expression;
use yii\helpers\Json;
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
        $daysLimit = 30;
        $ordersAmount = Order::find()->count();
        $latestOrders = Order::find()->where(['>=', 'created_at', new Expression("NOW() - INTERVAL {$daysLimit} DAY")])->asArray()->all();
        $usersAmount = User::find()->where(['status' => Status::ACTIVE])->count();
        $latestUsers = User::find()->where(['status' => Status::ACTIVE])->andWhere(['>=', 'created_at', new Expression("NOW() - INTERVAL {$daysLimit} DAY")])->asArray()->all();
        $devicesAmount = Device::find()->where(['status' => Status::ACTIVE])->count();
        $latestDevices = Device::find()->where(['status' => Status::ACTIVE])->andWhere(['>=', 'created_at', new Expression("NOW() - INTERVAL {$daysLimit} DAY")])->asArray()->all();

        return $this->render('index', [
            'printsData' => $this->getPrintsData(),
            'salesData' => $this->getData($latestOrders, $ordersAmount, $daysLimit),
            'usersData' => $this->getData($latestUsers, $usersAmount, $daysLimit),
            'devicesData' => $this->getData($latestDevices, $devicesAmount, $daysLimit),
            'feedbacksData' => $this->getFeedbackData(),
        ]);
    }

    /**
     * Prepares data in needed format for dashboard
     *
     * @param $items
     * @param $total
     * @param $daysLimit
     * @param int $comparisonDays
     * @return array
     */
    public function getData($items, $total, $daysLimit, $comparisonDays = 7)
    {
        $sparkData = [
            'latest' => [
                'digits' => [],
                'labels' => [],
            ],
            'total' => $total,
            'comparisonPercentage' => 0,
        ];
        $comparisonPrintsAmount = 0;
        $comparisonLPrintsAmount = 0;
        $begin = new \DateTime(Carbon::now()->subDay($daysLimit - 1)->toDateTimeString());
        $end = new \DateTime(Carbon::now()->toDateTimeString());
        $n = 0;

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $sparkData['latest']['digits'][$n] = 0;
            $sparkData['latest']['labels'][$n] = $i->format('Y-m-d');
            foreach ($items as $item) {
                $createdAt = (new \DateTime($item['created_at']))->format('Y-m-d');
                if ($i->format('Y-m-d') === $createdAt) {
                    $sparkData['latest']['digits'][$n]++;
                }
            }
            // Count total sales and prints per last n days
            if ($daysLimit - $n <= $comparisonDays) {
                $comparisonPrintsAmount += $sparkData['latest']['digits'][$n];
            }
            // Count total sales and prints per prev n days
            if ($daysLimit - $n > $comparisonDays && $daysLimit - $n <= $comparisonDays * 2) {
                $comparisonLPrintsAmount += $sparkData['latest']['digits'][$n];
            }
            $n++;
        }
        $comparisonLPrintsAmount = $comparisonLPrintsAmount > 0 ? $comparisonLPrintsAmount : 1;
        $sparkData['comparisonPercentage'] = intval(($comparisonPrintsAmount - $comparisonLPrintsAmount) / $comparisonLPrintsAmount * 100);

        return $sparkData;
    }

    /**
     * @param int $daysLimit
     * @param int $comparisonDays
     * @return array
     */
    public function getPrintsData($daysLimit = 30, $comparisonDays = 7)
    {
        $sparkPrints = [
            'latest' => [
                'digits' => [],
                'labels' => [],
            ],
            'total' => 0,
            'comparisonPercentage' => 0,
        ];
        $comparisonPrintsAmount = 0;
        $comparisonLPrintsAmount = 0;
        $prints = Action::find()->where(['or', ['action_type' => Type::PRINT], ['action_type' => Type::PRINT_SHIPMENT]])->asArray()->all();
        $lastDaysPrints = [];

        foreach ($prints as $print) {
            // Calculate total prints
            $printData = Json::decode($print['data']);
            if (!empty($printData['images'])) {
                foreach ($printData['images'] as $img) {
                    $sparkPrints['total'] += $img['count'];
                }
            }

            // Add to latest prints
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $print['created_at']);
            if ($date->between(Carbon::now()->subDay($daysLimit), Carbon::now())) {
                array_push($lastDaysPrints, $print);
            }
        }

        $begin = new \DateTime(Carbon::now()->subDay($daysLimit - 1)->toDateTimeString());
        $end = new \DateTime(Carbon::now()->toDateTimeString());
        $n = 0;
        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $sparkPrints['latest']['digits'][$n] = 0;
            $sparkPrints['latest']['labels'][$n] = $i->format('Y-m-d');
            foreach ($lastDaysPrints as $print) {
                $createdAt = (new \DateTime($print['created_at']))->format('Y-m-d');
                if ($i->format('Y-m-d') === $createdAt) {
                    $printData = Json::decode($print['data']);
                    if (!empty($printData['images'])) {
                        foreach ($printData['images'] as $img) {
                            $sparkPrints['latest']['digits'][$n] += $img['count'];
                        }
                    }
                }
            }
            // Count total sales and prints per last n days
            if ($daysLimit - $n <= $comparisonDays) {
                $comparisonPrintsAmount += $sparkPrints['latest']['digits'][$n];
            }
            // Count total sales and prints per prev n days
            if ($daysLimit - $n > $comparisonDays && $daysLimit - $n <= $comparisonDays * 2) {
                $comparisonLPrintsAmount += $sparkPrints['latest']['digits'][$n];
            }
            $n++;
        }
        $comparisonLPrintsAmount = $comparisonLPrintsAmount > 0 ? $comparisonLPrintsAmount : 1;
        $sparkPrints['comparisonPercentage'] = intval(($comparisonPrintsAmount - $comparisonLPrintsAmount) / $comparisonLPrintsAmount * 100);

        return $sparkPrints;
    }

    /**
     * Returns feedback data for dashboard
     *
     * @return mixed
     */
    public function getFeedbackData()
    {
        $feedbacks = Action::find()->where(['action_type' => Type::FEEDBACK])->all();
        $feedbackData['rating'] = 0;
        $feedbackData['amount'] = 0;
        foreach ($feedbacks as $feedback) {
            $data = Json::decode($feedback['data']);
            if ($data['question'] == 'Rate') {
                $feedbackData['rating'] += (int)$data['answer'];
                $feedbackData['amount'] ++;
            }
        }
        $avg = ($feedbackData['rating'] <= 0 || $feedbackData['amount'] <= 0) ? 0 : $feedbackData['rating'] / $feedbackData['amount'];
        $feedbackData['avg'] = ($avg > 0) ? number_format($avg, 1) : 0;

        return $feedbackData;
    }
}
