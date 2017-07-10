<?

use fae\common\enums\user\Role;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;

/**
 * Partial view file for rendering navigation header.
 *
 * @var \yii\web\View $this Current view instance.
 */

$currentUser = Yii::$app->user->getIdentity();
?>

<li class="nav-header">

    <div class="dropdown profile-element text-center">

        <span>
            <img alt="image" class="img-circle" src="<?= $currentUser->profile->getAvatar(64) ?>"/>
        </span>

        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="clear">
                <span class="block m-t-xs">
                    <strong class="font-bold">
                        <?= Html::encode($currentUser->profile->name) ?>
                    </strong>
                </span>
                <span class="text-muted text-xs block">
                    <?= Role::getLabel($currentUser->role) ?>
                    <b class="caret"></b>
                </span>
            </span>
        </a>

        <?=
        Dropdown::widget([
            'options' => [
                'class' => 'm-t-xs',
            ],
            'items' => [
                [
                    'label' => Yii::t('fae/backend', 'Profile'),
                    'url' => '#',
                ],
                Html::tag('li', '', ['class' => 'divider']),
                [
                    'label' => Yii::t('fae/backend', 'Logout'),
                    'url' => ['/auth/sign-out'],
                    'linkOptions' => [
                        'data-method' => 'POST',
                    ],
                ],
            ],
        ])
        ?>

    </div>

    <div class="logo-element">
        FAE
    </div>

</li>
