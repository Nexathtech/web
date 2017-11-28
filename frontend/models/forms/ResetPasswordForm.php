<?php
namespace kodi\frontend\models\forms;

use Yii;
use yii\base\Model;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `ResetPasswordForm`
 * =========================
 *
 * This is the model class for "reset password" form.
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string $password
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'password' => Yii::t('frontend', 'Enter Your New Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['password'], RequiredValidator::class],

            // Strings validation
            [['password'], StringValidator::class, 'min' => 6, 'max' => 64],
        ];
    }
}
