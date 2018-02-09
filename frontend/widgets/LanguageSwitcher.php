<?php

namespace kodi\frontend\widgets;

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
        $supportedLanguages = Yii::$app->urlManager->languages;
        $currentLang = Yii::$app->language;
        foreach ($supportedLanguages as $sLang) {
            array_push($this->languages, [
                'alias' => $sLang,
                'title' => self::label($sLang),
                'active' => $sLang === $currentLang,
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

    /**
     * @param string $lang
     * @return mixed
     */
    public static function label($lang = 'en') {
        $labels = [
            'en' => 'eng',
            'it' => 'ita',
        ];

        return isset($labels[$lang]) ? $labels[$lang] : $labels['en'];
    }
}