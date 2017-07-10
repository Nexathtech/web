<?php

use Carbon\Carbon;
use kodi\common\enums\user\Role;
use kodi\common\enums\user\Status;
use yii\db\Migration;

/**
 * Migration `m130524_201442_init`
 * ===============================
 *
 * Declares initial database structure.
 */
class m130524_201442_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Database-specific settings
        $dbDriver = $this->db->getDriverName();
        if ($dbDriver !== 'mysql') {
            throw new Exception('Selected database driver is not supported!');
        }

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $primaryKeyField = 'INT UNSIGNED NOT NULL AUTO_INCREMENT';
        $createdAtField = 'TIMESTAMP NULL';
        $updatedAtField = 'TIMESTAMP NULL';

        // Table "user"
        $roleField = "ENUM('Administrator', 'Customer') NOT NULL";
        $statusField = "ENUM('Inactive', 'Active', 'Suspended') NOT NULL";

        $this->createTable('{{%user}}', [
            'id' => $primaryKeyField,
            'email' => $this->string(64)->notNull(),
            'password' => $this->string(64)->notNull(),
            'auth_key' => $this->string(64)->notNull(),
            'role' => $roleField,
            'status' => $statusField,
            'created_at' => $createdAtField,
            'updated_at' => $updatedAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('user_role_idx', '{{%user}}', 'role');
        $this->createIndex('user_status_idx', '{{%user}}', 'status');
        $this->createIndex('user_email_uq', '{{%user}}', 'email', true);

        // Table "user_profile"
        $this->createTable('{{%user_profile}}', [
            'id' => $primaryKeyField,
            'user_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(64)->notNull(),
            'photo' => $this->string(255),
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('user_profile_user_idx', '{{%user_profile}}', 'user_id');
        $this->addForeignKey('user_profile_user_fk', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Table "device"
        $this->createTable('{{%device}}', [
            'id' => $primaryKeyField,
            'user_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(64)->notNull(),
            'photo' => $this->string(255),
            'status' => "ENUM('Inactive', 'Active') NOT NULL",
            'access_token' => $this->string(64)->notNull(),
            'location_latitude' => $this->string(64),
            'location_longitude' => $this->string(64),
            'created_at' => $createdAtField,
            'updated_at' => $updatedAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('device_user_idx', '{{%device}}', 'user_id');
        $this->addForeignKey('device_user_fk', '{{%device}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Table "promo_code"
        $this->createTable('{{%promo_code}}', [
            'id' => $primaryKeyField,
            'code' => $this->string(64)->notNull(),
            'identity_id' => $this->string(255),
            'description' => $this->string(255),
            'status' => "ENUM('New', 'Used') NOT NULL",
            'created_at' => $createdAtField,
            'expires_at' => $createdAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('promo_code_identity_id_idx', '{{%promo_code}}', 'identity_id');

        // Table "social_user"
        $this->createTable('{{%social_user}}', [
            'id' => $primaryKeyField,
            'uuid' => $this->string(64)->notNull(),
            'name' => $this->string(255),
            'photo' => $this->string(255),
            'gender' => $this->string(64),
            'profile_url' => $this->string(255),
            'type' => "ENUM('Facebook', 'Instagram') NOT NULL",
            'created_at' => $createdAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('social_user_uuid_idx', '{{%social_user}}', 'uuid');

        // Table "action"
        $this->createTable('{{%action}}', [
            'id' => $primaryKeyField,
            'initiator' => $this->string(64)->notNull(),
            'initiator_id' => $this->string(64),
            'type' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'promo_code' => $this->string(8),
            'created_at' => $createdAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('action_type_idx', '{{%action}}', 'type');
        $this->createIndex('action_initiator_idx', '{{%action}}', 'initiator');

        // Table "setting"
        $settingType = "ENUM('Input', 'Textarea', 'Checkbox', 'Image') NOT NULL";
        $this->createTable('{{%setting}}', [
            'id' => $primaryKeyField,
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'name' => $this->string(64)->notNull(),
            'value' => $this->text(),
            'bunch' => $this->string(64)->notNull(),
            'type' => $settingType,
            'sort_order' => $this->integer()->defaultValue(1),
            'updated_at' => $updatedAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('setting_system_name_uq', '{{%setting}}', 'name', true);


        /**
         * ----------------
         * | Default data |
         * ----------------
         */

        $timestamp = Carbon::now()->toDateTimeString();

        // Create root user
        $security = Yii::$app->getSecurity();
        $this->insert('{{%user}}', [
            'email' => 'webmaster@meetkodi.com',
            'password' => $security->generatePasswordHash('12345678'),
            'auth_key' => $security->generateRandomString(64),
            'role' => Role::ADMINISTRATOR,
            'status' => Status::ACTIVE,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $userId = $this->db->getLastInsertID();
        $this->insert('{{%user_profile}}', [
            'user_id' => $userId,
            'name' => 'Mykola Popko',
        ]);

        // Add device
        $this->insert('{{%device}}', [
            'user_id' => $userId,
            'name' => 'First device',
            'status' => Status::ACTIVE,
            'access_token' => $security->generateRandomString(64),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Table "device"
        $this->dropForeignKey('device_user_fk', '{{%device}}');
        $this->dropTable('{{%device}}');

        // Table "user_profile"
        $this->dropForeignKey('user_profile_user_fk', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');

        // Table "user"
        $this->dropTable('{{%user}}');

        // Table "promo_code"
        $this->dropTable('{{%promo_code}}');

        // Table "social_user"
        $this->dropTable('{{%social_user}}');

        // Table "action"
        $this->dropTable('{{%action}}');

        // Table "setting"
        $this->dropTable('{{%setting}}');
    }
}
