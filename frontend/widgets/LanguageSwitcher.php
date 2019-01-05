<?php

namespace kodi\frontend\widgets;

use kodi\common\enums\Language;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class LanguageSwitcher
 * ======================
 *
 * @package kodi\frontend\widgets
 */
class LanguageSwitcher extends Widget
{
    /**
     * @var array $languages
     */
    private $languages = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $supportedLanguages = Language::listData();
        $currentLang = Yii::$app->language;
        $currentUrl = $_SERVER['REQUEST_URI'];

        foreach ($supportedLanguages as $key => $lang) {
            $title = strtolower(substr($lang, 0, 3));
            $title = str_replace('por', 'pt', $title);
            array_push($this->languages, [
                'alias' => $key,
                'title' => $title,
                'active' => $key === $currentLang,
                'url' => str_replace("/{$currentLang}", '/', $currentUrl),
            ]);
        }

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('languageSwitcher', [
            'languages' => $this->languages,
        ]);
    }
}
