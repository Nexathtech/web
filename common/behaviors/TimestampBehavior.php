<?php

namespace kodi\common\behaviors;

use Carbon\Carbon;

/**
 * Class `TimestampBehavior`
 * =========================
 *
 * This is a customized timestamp behavior that is using [[Carbon]] by default to determine current timestamp.
 */
class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
    /**
     * @inheritdoc
     */
    public function getValue($event)
    {
        if (empty($this->value)) {
            $this->value = function () {
                return Carbon::now()->toDateTimeString();
            };
        }

        return parent::getValue($event);
    }
}
