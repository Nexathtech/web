<?

use rmrevin\yii\fontawesome\FA;

/**
 * The view file for the "configuration/server-info" action.
 *
 * @var  \yii\web\View $this
 */

$this->title = Yii::t('backend', 'Server info');
$this->params['description'] = Yii::t('backend', 'Current server configuration');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'Configuration'),
        'url' => ['/configuration'],
    ],
    $this->title,
];
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs float-xs-left">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#server-info-php">
                            <?= FA::icon('server') ?>
                            PHP
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-block m-t-15">
                <div class="tab-content">
                    <div class="tab-pane active" id="server-info-php">
                        <?
                        // Display PHP info without any CSS rules
                        ob_start();
                        phpinfo();
                        $phpInfo = ob_get_contents();
                        ob_end_clean();
                        $phpInfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpInfo);
                        echo $phpInfo;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
