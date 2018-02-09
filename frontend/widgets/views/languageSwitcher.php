<?php

use yii\helpers\Url;

/**
 * Partial view file for rendering Language filter widget.
 *
 * @var \yii\web\View $this Current view instance.
 * @var array $languages
 */
?>

<div class="language-switcher">
<? foreach ($languages as $lang): ?>
    <? if ($lang['active']): ?>
        <div class="lang"><?= $lang['title']; ?></div>
    <? break; endif; ?>
<? endforeach; ?>
    <ul>
        <? foreach ($languages as $lang): ?>
            <? if (!$lang['active']): ?>
                <li>
                    <a href="<?= Url::to([$lang['url'], 'language' => $lang['alias']]); ?>">
                        <?= $lang['title']; ?>
                    </a>
                </li>
            <? endif; ?>
        <? endforeach; ?>
    </ul>
</div>
