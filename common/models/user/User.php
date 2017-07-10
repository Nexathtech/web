<?php
namespace kodi\common\models\user;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\user\Role;
use kodi\common\enums\user\Status;
use kodi\common\models\device\Device;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\validators\UniqueValidator;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $role
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * Available AR relations:
 * -----------------------
 *
 * @property Profile $profile
 * @property Device[] $devices
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var int $new_password uses to update user's current password
     */
    public $new_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required fields
            [['email'], RequiredValidator::class],

            // Strings validation
            [['email', 'password', 'role', 'status', 'new_password'], StringValidator::class, 'max' => 64],

            // Range validation
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],

            // Unique fields
            [['email'], UniqueValidator::class],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'email' => Yii::t('common', 'Email'),
            'password' => Yii::t('common', 'Password'),
            'auth_key' => Yii::t('common', 'Auth Key'),
            'role' => Yii::t('common', 'Role'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'new_password' => Yii::t('common', 'New Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert): bool
    {
        // Set auto-generated fields
        if ($insert) {
            $security = Yii::$app->getSecurity();
            $this->setAttributes([
                'password' => (!empty($this->password)) ? $security->generatePasswordHash($this->password) : $security->generatePasswordHash($security->generateRandomString(8)),
                'auth_key' => $security->generateRandomString(64),
            ], false);
        }

        if (!empty($this->new_password)) {
            $security = Yii::$app->getSecurity();
            $this->setAttributes([
                'password' => $security->generatePasswordHash($this->new_password),
            ], false);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::find()
            ->with(['profile'])
            ->where(['id' => $id])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Returns user profile.
     *
     * @return ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * Returns user devices.
     *
     * @return ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::class, ['user_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * @return bool|true if user is admin and false if not
     */
    public function getIsAdmin()
    {
        return $this->role == Role::ADMINISTRATOR;
    }
}
