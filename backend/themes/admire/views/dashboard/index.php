<?php

use kodi\backend\themes\admire\assets\ChartistAsset;
use kodi\backend\themes\admire\assets\ChartistTooltipAsset;
use kodi\backend\themes\admire\assets\CountUpAsset;
use kodi\backend\themes\admire\assets\FlipAsset;
use kodi\backend\themes\admire\assets\SparklineAsset;
use kodi\backend\themes\admire\assets\ThemeAsset;
use rmrevin\yii\fontawesome\FA;

/**
 * The view file for the "dashboard/index" action.
 *
 * @var  \yii\web\View $this
 * @var array $usersData
 * @var array $subscriptionsData
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
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="user_font">Prints</div>
                            <div id="widget_countup1">3,250</div>
                            <div class="tag-white">
                                <span id="percent_count1">85</span>%
                            </div>
                            <div class="previous_font">Yearly Users stats</div>
                        </div>
                    </div>
                    <div class="back">
                        <div class="bg-white b_r_5 section_border">
                            <div class="p-t-l-r-15">
                                <div class="float-xs-right m-t-5">
                                    <i class="fa fa-users text-primary"></i>
                                </div>
                                <div id="widget_countup12">3,250</div>
                                <div>Users</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <span id="visitsspark-chart"></span>
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
                            <div class="user_font">Sales</div>
                            <div id="widget_countup2">1,140</div>
                            <div class="tag-white">
                                <span id="percent_count2">60</span>%
                            </div>
                            <div class="previous_font">Sales per month</div>
                        </div>
                    </div>

                    <div class="back">
                        <div class="bg-white b_r_5 section_border">
                            <div class="p-t-l-r-15">
                                <div class="float-xs-right m-t-5 text-success">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div id="widget_countup22">1,140</div>
                                <div>Sales</div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <span id="salesspark-chart"></span>
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

                    <div class="back">
                        <div class="bg-white b_r_5 section_border">
                            <div class="p-t-l-r-15">
                                <div class="float-xs-right m-t-5 text-warning">
                                    <i class="fa fa-comments-o"></i>
                                </div>
                                <div id="widget_countup32">85</div>
                                <div>Comments</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <span id="mousespeed"></span>
                                </div>
                            </div>
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
                            <div class="user_font">Rating</div>
                            <div id="widget_countup4">8</div>
                            <div class="tag-white">
                                <span id="percent_count4">80</span>%
                            </div>
                            <div class="previous_font">This month ratings </div>
                        </div>
                    </div>

                    <div class="back">
                        <div class="bg-white section_border b_r_5">
                            <div class="p-t-l-r-15">
                                <div class="float-xs-right m-t-5 text-danger">
                                    <i class="fa fa-star-o"></i>
                                </div>

                                <div id="widget_countup42">8</div>
                                <div>Rating</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <span id="rating"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row m-t-35">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <span class="card-title">Today Stats</span>
                        <div class="dropdown chart_drop float-xs-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
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

