<?

use kodi\frontend\assets\AppAsset;
use yii\helpers\Html;

/**
 * The view file for the "order/index" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @var $price float price per unit
 * @var $orderDetails array details about checked data before
 * @see \kodi\frontend\controllers\OrderController::actionIndex()
 */

$this->title = Yii::t('frontend', 'Kodi Order');

$this->registerJsFile('@web/js/order.js', ['depends' => AppAsset::class]);
$quantity = $orderDetails['quantity'];
$color = $orderDetails['color'];
?>

<div class="page-order page-regular">
    <div class="page-title">
        <div class="active"><?= Yii::t('frontend', 'Order details'); ?></div>
        <div class="title-delimiter"></div>
        <div class="passive"><?= Yii::t('frontend', 'Information details'); ?></div>
        <div class="title-delimiter"></div>
        <div class="passive"><?= Yii::t('frontend', 'Payment'); ?></div>
    </div>

    <div class="page-content order-content">
        <div class="o-c-wide">
            <div class="o-c-w-left text-right">
                <div class="order-price">$<?= number_format($price, 0, '.', '.'); ?></div>
                <div class="order-mark o-m-medium o-m-1"><?= Yii::t('frontend', 'per unit'); ?></div>
                <div class="order-title"><?= Yii::t('frontend', 'choose your color'); ?></div>

                <div class="order-color-choose">
                    <div class="o-c-blue<?= ($color === 'blue') ? ' active' : ''; ?>" data-color="blue" data-image="/styles/img/rocket-blue.png"></div>
                    <div class="o-c-pink<?= ($color === 'pink') ? ' active' : ''; ?>" data-color="pink" data-image="/styles/img/rocket-pink.png"></div>
                    <div class="o-c-yellow<?= ($color === 'yellow') ? ' active' : ''; ?>" data-color="yellow" data-image="/styles/img/rocket-middle.jpg"></div>
                </div>
                <div class="order-mark text-gray o-m-2">
                    <?= Yii::t('frontend', 'need to brand? {contact_us}', [
                        'contact_us' => Html::a(Yii::t('frontend', 'contact us'), '/about#contact'),
                    ]); ?>
                </div>

                <div class="order-quantity">
                    <?= Yii::t('frontend', 'quantity'); ?>
                    <span class="o-q-minus">-</span>
                    <span class="o-q"><?= $quantity; ?></span>
                    <span class="o-q-plus">+</span>
                </div>
                <div class="order-mark text-gray o-m-3">
                    <?= Yii::t('frontend', 'more than 5? {contact_us}', [
                        'contact_us' => Html::a(Yii::t('frontend', 'contact us'), '/about#contact'),
                    ]); ?>
                </div>

                <div class="order-caution text-gray">
                    <p><?= Yii::t('frontend', 'Prices do not include import fees or taxes'); ?></p>
                    <p><?= Yii::t('frontend', 'Down payments are final and non-refundable'); ?></p>
                    <p><?= Yii::t('frontend', 'Lead times for large orders is currently 8 weeks'); ?></p>
                    <p><?= Yii::t('frontend', 'Have open questions? Please {contact_us}', [
                        'contact_us' => Html::a(Yii::t('frontend', 'contact us'), '/about#contact'),
                        ]); ?></p>
                </div>
            </div>
            <div class="o-c-w-right">
                <img class="o-c-img" src="/styles/img/rocket-middle.jpg">
            </div>
        </div>
        <div class="o-c-medium">
            <div class="o-due-title">
                <?= Yii::t('frontend', 'Due now'); ?>:
                $<span class="o-due-sum"><?= number_format($price * $quantity, 0, '.', '.'); ?></span>
                <div class="order-mark text-gray">
                    <?= Yii::t('frontend', 'All the instructions will be followed by email'); ?>
                </div>
            </div>
            <?= Html::beginForm('', 'post', ['class' => 'o-submit-form']); ?>
            <div class="o-agreement checkbox-container">
                <?= Html::input('checkbox', 'tac_agreement', null, ['id' => 'tac-agreement']); ?>
                <?= Html::label(Yii::t('frontend', 'I have read and accept the {terms_and_conditions}', [
                    'terms_and_conditions' => Html::a(Yii::t('frontend', 'Terms and conditions'), ['/terms-and-conditions'], ['target' => '_blank']),
                ]), 'tac-agreement'); ?>
            </div>
            <div class="o-agreement checkbox-container">
                <?= Html::input('checkbox', 'p_agreement', null, ['id' => 'p-agreement']); ?>
                <?= Html::label(Yii::t('frontend', 'I have read and accept the {purchase_agreement}', [
                    'purchase_agreement' => Html::a(Yii::t('frontend', 'Purchase agreement'), ['/purchase-agreement'], ['target' => '_blank']),
                ]), 'p-agreement'); ?>
            </div>
            <?= Html::hiddenInput('color', $color); ?>
            <?= Html::hiddenInput('quantity', $quantity); ?>
            <?= Html::submitButton(Yii::t('frontend', 'Yes, I want it'), ['class' => 'btn btn-md disabled']); ?>
            <?= Html::endForm(); ?>
        </div>
    </div>

    <a class="page-close" href="/"></a>
</div>
