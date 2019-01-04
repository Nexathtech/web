<?

namespace kodi\common\components\wording;

use yii\base\ErrorException;

/**
 * Class `Wording`
 * =============
 *
 * Translates keys to meaningful phrases
 * Helpful when some fields with json data are used (order_data etc.)
 */
class Wording
{
    public $phrases = [];

    /**
     * Includes specified category (if found)
     * And performs the translation based on its data
     *
     * @param $phrase
     * @param string $category
     * @return mixed
     */
    public function t($phrase, $category = 'common')
    {
        if (empty($this->phrases[$category])) {
            try {
                $this->phrases[$category] = include "phrases/{$category}.php";
            } catch (ErrorException $exception) {
                $this->phrases[$category] = [];
            }
        }

        if (!empty($this->phrases[$category][$phrase])) {
            return $this->phrases[$category][$phrase];
        }

        return $phrase;
    }
}
