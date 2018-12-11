<?php

use kodi\common\models\Action;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Partial file for order view
 *
 * @var $data \kodi\common\models\Order
 * @var array $adImages
 */

$actionId = 0;
$actionAdImages = [];
$html = '';
if (!empty($data->order_data)) {
    $orderData = Json::decode($data->order_data);
    if (!empty($orderData['action_id'])) {
        $actionId = $orderData['action_id'];
        $action = Action::findOne(['id' => $actionId]);
        if (!empty($action)) {
            $actionData = Json::decode($action->data);
            $images = ArrayHelper::getValue($actionData, 'images', []);
            foreach ($images as $image) {
                $iClass = ArrayHelper::getValue($image, 'dimensions.orientation', 'vertical');
                $img = Html::img($image['path']);
                $item = Html::tag('div', $img, ['class' => "p-img {$iClass}"]);
                for ($i=0; $i<$image['count']; $i++) {
                    $html .= Html::tag('div', $item, ['class' => 'p-item']);
                }
            }

            // Now show advertisement images
            $actionAdImages = ArrayHelper::getValue($actionData, 'adImages', []);
            /*if (empty($actionAdImages)) {
                $img = Html::img($adImages[0]['image'], ['class' => 'ad']);
                $html .= Html::tag('div', $img, ['class' => 'p-item']);
            }*/
            foreach ($actionAdImages as $src) {
                $img = Html::img($src, ['class' => 'ad']);
                $html .= Html::tag('div', $img, ['class' => 'p-item']);
            }
        }
    }
}

if (!empty($html)) {
    $html = Html::tag('div', $html, ['class' => 'print-block']);
    $aTitle = FA::i('print') . ' Print photos';
    $html .= Html::a($aTitle, '#', ['class' => 'btn btn-success my-1 print-btn']);
    $html .= Html::a(Yii::t('backend', 'More photos...'), '#', ['class' => 'btn btn-info more-photos-btn']);
    $html .= Html::beginTag('div', ['class' => 'more-photos']);
    $imageTypes = [];
    foreach ($adImages as $img) {
        $iType = strtolower($img['type']);
        if (!in_array($iType, $imageTypes)) {
            array_push($imageTypes, $iType);
        }
    }

    $html .= Html::beginTag('div', ['class' => 'i-filter']);
    foreach ($imageTypes as $iType) {
        $html .= Html::tag('span', $iType);
    }
    $html .= Html::endTag('div');

    foreach ($adImages as $i => $img) {
        $imgClass = strtolower($img['type']);
        //if ($i === 0) { $imgClass .= ' active'; }
        if (in_array($img['image'], $actionAdImages)) {
            $imgClass .= ' active';
        }
        $html .= Html::img($img['image'], ['class' => $imgClass, 'data-action-id' => $actionId]);
    }

    $html .= Html::endTag('div');
}

echo $html;
?>
