<?php

use kodi\common\enums\action\Type;
use kodi\common\enums\user\Status;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * The view file for the "List service accounts" page.
 *
 * @var \yii\web\View $this
 * @var \kodi\common\models\user\User $model
 *
 * @see \kodi\backend\controllers\UserController::actionView()
 */

$this->title = Yii::t('backend', 'View user "{name}"', ['name' => Html::encode($model->profile->name)]);
$this->params['description'] = FA::i('user') . ' ' . Yii::t('backend', 'System users');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('backend', 'User management'),
        'url' => ['/user'],
    ],
    $this->title,
];
?>

<div class="outer">
    <div class="inner bg-container">
        <div class="card">
            <div class="card-header bg-white"><?= Yii::t('backend', 'Users list') ?></div>
            <div class="card-block m-t-35">
                <div class="table-responsive">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'profile.photo',
                                'format' => ['image', ['style' => 'max-width: 120px;']],
                            ],
                            'profile.name',
                            'profile.surname',
                            'email:email',
                            'role',
                            'type',
                            [
                                'label' => $model->getAttributeLabel('status'),
                                'format' => 'html',
                                'value' => Html::tag('span', $model->status, [
                                    'class' => ($model->status == Status::ACTIVE) ? 'label label-success' : 'label label-default',
                                ]),
                            ],
                            'profile.country',
                            'profile.city',
                            'profile.state',
                            'profile.address',
                            'profile.postcode',
                            'created_at:datetime',
                            'updated_at:datetime',
                            [
                                'label' => Yii::t('backend', 'Devices'),
                                'format' => 'html',
                                'value' => function($data) {
                                    $result = '';
                                    foreach ($data->devices as $device) {
                                        $result .= Html::tag('div', Html::a($device->uuid, ['/device/view', 'id' => $device->id]));
                                    }

                                    return $result;
                                },
                            ],
                            [
                                'label' => Yii::t('backend', 'Settings'),
                                'format' => 'html',
                                'value' => function($data) {
                                    $result = '';
                                    foreach ($data->settings as $setting) {
                                        $result .= Html::beginTag('div');
                                        $result .= Html::tag('strong', $setting->title);
                                        $result .= ": {$setting->value}";
                                        $result .= Html::endTag('div');
                                    }

                                    return $result;
                                }
                            ],
                            [
                                'label' => Yii::t('backend', 'Actions'),
                                'format' => 'html',
                                'value' => function($data) {
                                    $actionTypes = Type::listData();
                                    $result = '';
                                    foreach ($data->actions as $action) {
                                        $result .= Html::beginTag('div');
                                        $result .= Html::a("{$action->id} ({$actionTypes[$action->action_type]})", ['/action/view', 'id' => $action->id]);
                                        $result .= Html::endTag('div');
                                    }

                                    return $result;
                                }
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
