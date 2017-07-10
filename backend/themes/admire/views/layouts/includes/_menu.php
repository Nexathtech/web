<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;

/**
 * Partial view file for rendering left menu.
 *
 * @var \kodi\common\models\user\User $user
 */

$controller = $this->context;
?>

<div class="menu_scroll">
    <div class="left_media">
        <div class="media user-media bg-dark dker">
            <div class="user-media-toggleHover">
                <span class="fa fa-user"></span>
            </div>
            <div class="user-wrapper bg-dark">
                <a class="user-link" href="/">
                    <img class="media-object img-thumbnail user-img rounded-circle admin_img3" alt="User Picture" src="<?= $user->profile->getPhoto(); ?>">
                    <p class="user-info menu_hide"><?= Yii::t('backend', 'Welcome {name}', ['name' => $user->profile->getFirstName()]); ?></p>
                </a>
            </div>
        </div>
        <hr>
    </div>
    <ul id="menu">
        <li class="<?= ($controller->id === 'dashboard') ? 'active' : '' ?>">
            <a href="<?= Yii::$app->homeUrl; ?>">
                <?= FA::i('tachometer'); ?>
                <span class="link-title menu_hide"><?= Yii::t('backend', 'Dashboard'); ?></span>
            </a>
        </li>
        <li class="<?= ($controller->id === 'user') ? 'active' : '' ?>">
            <a href="<?= Url::to(['/user']); ?>">
                <?= FA::i('users'); ?>
                <span class="link-title menu_hide"><?= Yii::t('backend', 'Users'); ?></span>
            </a>
        </li>
        <li class="<?= ($controller->id === 'device') ? 'active' : '' ?>">
            <a href="<?= Url::to(['/device']); ?>">
                <?= FA::i('android'); ?>
                <span class="link-title menu_hide"><?= Yii::t('backend', 'Kiosk Devices'); ?></span>
            </a>
        </li>
        <li class="<?= ($controller->id === 'action') ? 'active' : '' ?>">
            <a href="<?= Url::to(['/action']); ?>">
                <?= FA::i('bullseye'); ?>
                <span class="link-title menu_hide"><?= Yii::t('backend', 'Actions'); ?></span>
            </a>
        </li>
        <li class="dropdown_menu <?= ($controller->id === 'promo-code' || $controller->id === 'social-user') ? 'active' : '' ?>">
            <a href="javascript:;">
                <?= FA::i('bullhorn'); ?>
                <span class="link-title menu_hide"><?= Yii::t('backend', 'Marketing'); ?></span>
                <span class="fa arrow menu_hide"></span>
            </a>
            <ul class="collapse">
                <li class="<?= ($controller->id === 'promo-code') ? 'active' : ''; ?>">
                    <a href="<?= Url::to(['/promo-code']); ?>">
                        <?= FA::i('credit-card-alt'); ?>
                        <?= Yii::t('backend', 'Promo codes'); ?>
                    </a>
                </li>
                <li class="<?= ($controller->id === 'social-user') ? 'active' : ''; ?>">
                    <a href="<?= Url::to(['/social-user']); ?>">
                        <?= FA::i('user-circle-o'); ?>
                        <?= Yii::t('backend', 'Social users'); ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown_menu <?= ($controller->id === 'general' || $controller->id === 'settings') ? 'active' : '' ?>">
            <a href="javascript:;">
                <?= FA::i('cogs'); ?>
                <span class="link-title menu_hide"><?= Yii::t('backend', 'Configuration'); ?></span>
                <span class="fa arrow menu_hide"></span>
            </a>
            <ul class="collapse">
                <li class="<?= ($controller->action->id === 'server-info') ? 'active' : '' ?>">
                    <a href="<?= Url::to(['/general/server-info']); ?>">
                        <?= FA::i('info-circle'); ?>
                        <?= Yii::t('backend', 'Server info'); ?>
                    </a>
                </li>
                <li class="<?= ($controller->id === 'settings') ? 'active' : '' ?>">
                    <a href="<?= Url::to(['/settings']); ?>">
                        <?= FA::i('cog'); ?>
                        <span class="link-title"><?= Yii::t('backend', 'General Settings'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- /#menu -->
</div>