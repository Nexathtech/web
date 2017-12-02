<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * The view file for the "order/info" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $model \kodi\common\models\Order
 * @see \kodi\frontend\controllers\OrderController::actionInfo()
 */

$this->title = Yii::t('frontend', 'Kodi Order information details');

$labelName = Yii::t('frontend', 'first name');
$labelSurname = Yii::t('frontend', 'last name');
$labelEmail = Yii::t('frontend', 'email');
$labelCompany = Yii::t('frontend', 'company');
$labelCountry = Yii::t('frontend', 'country');
$labelCity = Yii::t('frontend', 'city');
$labelState = Yii::t('frontend', 'state');
$labelAddress = Yii::t('frontend', 'address');
$labelAddress2 = Yii::t('frontend', 'address line 2');
$labelPostcode = Yii::t('frontend', 'postcode');
?>

<div class="page-order order-info page-regular">
    <div class="page-title">
        <a href="/order" class="passive"><?= Yii::t('frontend', 'Order details'); ?></a>
        <div class="title-delimiter"></div>
        <div class="active"><?= Yii::t('frontend', 'Information details'); ?></div>
        <div class="title-delimiter"></div>
        <div class="passive"><?= Yii::t('frontend', 'Payment'); ?></div>
    </div>

    <div class="page-content order-content">
        <? $form = ActiveForm::begin(['options' => ['class' => 'order-info']]); ?>
        <div class="o-c-medium">
            <div class="o-c-m-content">
                <?= Html::label($labelName, 'order-name'); ?>
                <?= Html::label($labelSurname, 'order-surname'); ?>
                <?= Html::label($labelEmail, 'order-email'); ?>
                <?= Html::label($labelCompany, 'order-company'); ?>
                <?= Html::label($labelCountry, 'order-country'); ?>
                <?= Html::label($labelCity, 'order-city'); ?>
                <?= Html::label($labelState, 'order-state'); ?>
                <?= Html::label($labelAddress, 'order-address'); ?>
                <?= Html::label($labelAddress2, 'order-address2'); ?>
                <?= Html::label($labelPostcode, 'order-postcode'); ?>
            </div>
        </div>
        <div class="o-c-wide">
            <?= $form->field($model, 'name')->textInput(['placeholder' => $labelName])->label(false); ?>
            <?= $form->field($model, 'surname')->textInput(['placeholder' => $labelSurname])->label(false); ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => $labelEmail])->label(false); ?>
            <?= $form->field($model, 'company')->textInput(['placeholder' => $labelCompany])->label(false); ?>
            <?= $form->field($model, 'country')->textInput(['placeholder' => $labelCountry])->label(false); ?>
            <?= $form->field($model, 'city')->textInput(['placeholder' => $labelCity])->label(false); ?>
            <?= $form->field($model, 'state')->textInput(['placeholder' => $labelState])->label(false); ?>
            <?= $form->field($model, 'address')->textInput(['placeholder' => $labelAddress])->label(false); ?>
            <?= $form->field($model, 'address2')->textInput(['placeholder' => $labelAddress2])->label(false); ?>
            <?= $form->field($model, 'postcode')->textInput(['placeholder' => $labelPostcode])->label(false); ?>
            <?= $form->field($model, 'color')->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'quantity')->hiddenInput()->label(false); ?>
            <?= Html::submitButton('', ['class' => 'info-submit', 'title' => Yii::t('frontend', 'Next')]); ?>
        </div>
        <? ActiveForm::end(); ?>
    </div>

    <a class="page-close" href="/order"></a>
</div>
