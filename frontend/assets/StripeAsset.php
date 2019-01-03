<?php

namespace kodi\frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class StripeAsset extends AssetBundle
{
    public $js = [
        'https://js.stripe.com/v3/',
    ];
    public $depends = [
        AppAsset::class,
    ];
}
