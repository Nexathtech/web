<?php

use kodi\backend\themes\admire\assets\ChartistAsset;
use kodi\backend\themes\admire\assets\ChartistTooltipAsset;
use kodi\backend\themes\admire\assets\CountUpAsset;
use kodi\backend\themes\admire\assets\FlipAsset;
use kodi\backend\themes\admire\assets\SparklineAsset;
use kodi\backend\themes\admire\assets\ThemeAsset;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Json;

/**
 * The view file for the "dashboard/index" action.
 *
 * @var  \yii\web\View $this
 * @var array $printsData
 * @var array $salesData
 * @var array $feedbacksData
 */


$this->title = Yii::t('backend', 'Dashboard');
$this->params['description'] = FA::i('home') . ' ' . $this->title;

$themeUrl = $this->theme->getBaseUrl();
$this->registerJsFile("{$themeUrl}/js/pages/dashboard.js", ['depends' => [
    ThemeAsset::class,
    SparklineAsset::class,
    FlipAsset::class,
    CountUpAsset::class,
    ChartistAsset::class,
    ChartistTooltipAsset::class
]]);
$this->registerCssFile("{$themeUrl}/css/pages/dashboard.css", [
    'depends' => [ThemeAsset::class],
]);
$printsDataEncoded = Json::encode($printsData);
$salesDataEncoded = Json::encode($salesData);
$this->registerJs("
  initWidgets({$printsDataEncoded}, {$salesDataEncoded});
");
?>

<div class="outer">
    <div class="inner bg-container">
        <!--top section widgets-->
        <div class="row widget_countup">
            <div class="col-xs-12 col-sm-6 col-xl-3">

                <div id="top_widget1">
                    <div class="front">
                        <div class="bg-primary p-d-15 b_r_5">
                            <div class="float-xs-right m-t-5">
                                <?= FA::i('print'); ?>
                            </div>
                            <div class="user_font"><?= Yii::t('backend', 'Prints'); ?></div>
                            <div id="widget_countup1"><?= $printsData['total']; ?></div>
                            <div class="previous_font">
                                <strong><?= $printsData['weeklyPercentage']; ?>%</strong>
                                <?= Yii::t('backend', 'Weekly Prints stats') ?>
                            </div>
                        </div>
                    </div>
                    <div class="back">
                        <div class="bg-white b_r_5 section_border">
                            <div class="p-t-l-r-15">
                                <div class="float-xs-right m-t-5">
                                    <?= FA::i('print'); ?>
                                </div>
                                <div id="widget_countup12"><?= $printsData['total']; ?></div>
                                <div><?= Yii::t('backend', 'Total photos printed'); ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <span id="prints-chart"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-xl-3 media_max_573">
                <div id="top_widget2">
                    <div class="front">
                        <div class="bg-success p-d-15 b_r_5">
                            <div class="float-xs-right m-t-5">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="user_font"><?= Yii::t('backend', 'Sales'); ?></div>
                            <div id="widget_countup2"><?= $salesData['total']; ?></div>
                            <div class="previous_font">
                                <strong><?= $salesData['weeklyPercentage'] ?></strong>
                                <?= Yii::t('backend', 'Sales per week') ?>
                            </div>
                        </div>
                    </div>

                    <div class="back">
                        <div class="bg-white b_r_5 section_border">
                            <div class="p-t-l-r-15">
                                <div class="float-xs-right m-t-5 text-success">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div id="widget_countup22"><?= $salesData['total']; ?></div>
                                <div><?= Yii::t('backend', 'Total sales'); ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <span id="sales-chart"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-6 col-xl-3 media_max_1199">
                <div id="top_widget3">
                    <div class="front">
                        <div class="bg-warning p-d-15 b_r_5">
                            <div class="float-xs-right m-t-5">
                                <i class="fa fa-comments-o"></i>
                            </div>
                            <div class="user_font">Comments</div>
                            <div id="widget_countup3">85</div>
                            <div class="tag-white ">
                                <span id="percent_count3">30</span>%
                            </div>
                            <div class="previous_font">Monthly comments</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-6 col-xl-3 media_max_1199">
                <div id="top_widget4">
                    <div class="front">
                        <div class="bg-danger p-d-15 b_r_5">
                            <div class="float-xs-right m-t-5">
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="user_font"><?= Yii::t('backend', 'Rating'); ?></div>
                            <div id="widget_countup4"><?= $feedbacksData['avg']; ?></div>
                            <div><?= Yii::t('backend', 'Average value'); ?></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row m-t-35">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <span class="card-title"><?= Yii::t('backend', 'Daily stats'); ?></span>
                        <div class="dropdown chart_drop float-xs-right">
                            <i class="fa fa-arrows-alt"></i>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="demo-chartist mb-md m-t-15" id="chart1"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

