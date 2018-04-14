<?php

namespace kodi\backend\controllers;

use Carbon\Carbon;
use kodi\common\enums\action\Type;
use kodi\common\models\Action;
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
        $prints = Action::find()->where(['or', ['action_type' => Type::PRINT], ['action_type' => Type::PRINT_SHIPMENT]])->all();
        $lastDaysPrints = Action::find()->select('DATE(created_at) created_at, COUNT(id) id, data')->where(['or', ['action_type' => Type::PRINT], ['action_type' => Type::PRINT_SHIPMENT]])->orderBy('created_at DESC')->groupBy('DATE(created_at), id')->limit($daysLimit)->all();
        $lastDaysPrints = array_reverse($lastDaysPrints);
        $printSalesData = $this->getPrintSalesData($prints, $lastDaysPrints, $daysLimit);

        return $this->render('index', [
            'printsData' => $printSalesData['prints'],
            'salesData' => $printSalesData['sales'],
            'feedbacksData' => $this->getFeedbackData(),
        ]);
    }

    /**
     * Returns all sales and prints info in prepared format for dashboard
     *
     * @param $prints
     * @param $lastDaysPrints
     * @param $daysLimit
     * @return array
     */
    public function getPrintSalesData($prints, $lastDaysPrints, $daysLimit)
    {
        $sparkSales = [];
        $sparkPrints = [];
        $last7DaysPrintsAmount = 0;
        $last7DaysSalesAmount = 0;
        $prev7DaysPrintsAmount = 0;
        $prev7DaysSalesAmount = 0;
        $begin = new \DateTime(Carbon::now()->subDay($daysLimit - 1)->toDateTimeString());
        $end = new \DateTime(Carbon::now()->toDateTimeString());

        $n = 0;
        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $sparkSales['digits'][$n] = 0;
            $sparkSales['labels'][$n] = $i->format('Y-m-d');
            $sparkPrints['digits'][$n] = 0;
            $sparkPrints['labels'][$n] = $i->format('Y-m-d');
            foreach ($lastDaysPrints as $print) {
                $createdAt = (new \DateTime($print['created_at']))->format('Y-m-d');
                $photos = Json::decode($print['data']);
                if ($i->format('Y-m-d') == $createdAt) {
                    $sparkSales['digits'][$n] += $print['id'];
                    $sparkPrints['digits'][$n] += count($photos);
                }
            }
            // Count total sales and prints per last 7 days
            if ($daysLimit - $n <= 7) {
                $last7DaysSalesAmount += $sparkSales['digits'][$n];
                $last7DaysPrintsAmount += $sparkPrints['digits'][$n];
            }
            // Count total sales and prints per prev 7 days
            if ($daysLimit - $n > 7 && $daysLimit - $n <= 14) {
                $prev7DaysSalesAmount += $sparkSales['digits'][$n];
                $prev7DaysPrintsAmount += $sparkPrints['digits'][$n];
            }
            $n++;
        }

        $totalPrints = 0;
        foreach ($prints as $print) {
            $printData = Json::decode($print['data']);
            $totalPrints += count($printData);
        }

        return [
            'prints' => [
                'total' => $totalPrints,
                'latest' => $sparkPrints,
                'weeklyPercentage' => ($last7DaysPrintsAmount == 0 || $prev7DaysPrintsAmount == 0) ? 0 : intval($last7DaysPrintsAmount / $prev7DaysPrintsAmount * 100),
            ],
            'sales' => [
                'total' => count($prints),
                'latest' => $sparkSales,
                'weeklyPercentage' => ($last7DaysSalesAmount == 0 || $prev7DaysSalesAmount == 0) ? 0 : intval($last7DaysSalesAmount / $prev7DaysSalesAmount * 100),
            ],
        ];
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
