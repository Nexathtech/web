<?php

use rmrevin\yii\fontawesome\FA;

/**
 * Partial view file for rendering top nav bar.
 *
 * @var \kodi\common\models\user\User $user
 */

?>

<!-- .navbar -->
<nav class="navbar navbar-static-top">
    <div class="container-fluid">
        <a class="navbar-brand text-xs-center" href="<?= Yii::$app->homeUrl; ?>">
            <h3><img src="/img/logo.png" class="admin_img" alt="logo"></h3>
        </a>
        <div class="menu">
            <span class="toggle-left" id="menu-toggle"><?= FA::i('bars'); ?></span>
        </div>
        <div class="topnav dropdown-menu-right float-xs-right">
            <div class="btn-group">
                <div class="user-settings no-bg">
                    <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown">
                        <img src="<?= $user->profile->getPhoto(); ?>" class="admin_img2 img-thumbnail rounded-circle avatar-img" alt="avatar">
                        <strong><?= $user->profile->name; ?></strong>
                        <span class="fa fa-sort-down white_bg"></span>
                    </button>
                    <div class="dropdown-menu admire_admin">
                        <a class="dropdown-item title" href="#"><?= Yii::t('app', 'Kodi Admin'); ?></a>
                        <a class="dropdown-item" href="#">
                            <?= FA::i('cogs'); ?>
                            <?= Yii::t('app', 'Account Settings'); ?>
                        </a>
                        <a class="dropdown-item" href="#">
                            <?= FA::i('envelope'); ?>
                            <?= Yii::t('app', 'Inbox'); ?>
                        </a>
                        <a class="dropdown-item" href="/auth/sign-out">
                            <?= FA::i('sign-out'); ?>
                            <?= Yii::t('app', 'Log Out'); ?>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
</nav>
<!-- /.navbar -->
