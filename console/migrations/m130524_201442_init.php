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
            'surname' => $this->string(64),
            'photo' => $this->string(255),
            'country' => $this->string(64),
            'city' => $this->string(64),
            'state' => $this->string(64),
            'address' => $this->string(255),
            'postcode' => $this->string(64),
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('user_profile_user_idx', '{{%user_profile}}', 'user_id');
        $this->addForeignKey('user_profile_user_fk', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Table "user_auth_token"
        $this->createTable('{{%user_auth_token}}', [
            'id' => $primaryKeyField,
            'user_id' => $this->integer()->unsigned()->notNull(),
            'device_id' => $this->integer()->unsigned(),
            'token' => $this->string(128)->notNull(),
            'token_refresh' => $this->string(128),
            'type' => $this->string(64)->notNull(),
            'created_at' => $createdAtField,
            'expires_at' => $createdAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('user_auth_token_user_idx', '{{%user_auth_token}}', 'user_id');
        $this->addForeignKey('user_auth_token_user_fk', '{{%user_auth_token}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Table "user_auth_provider"
        $this->createTable('{{%user_auth_provider}}', [
            'id' => $primaryKeyField,
            'user_id' => $this->integer()->unsigned()->notNull(),
            'type' => "ENUM('Google', 'Facebook') NOT NULL",
            'external_id' => $this->string(64)->notNull(),
            'external_email' => $this->string(64)->notNull(),
            'external_image' => $this->string(255)->notNull(),
            'created_at' => $createdAtField,
            'updated_at' => $updatedAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('user_auth_provider_user_idx', '{{%user_auth_provider}}', 'user_id');
        $this->createIndex('user_auth_provider_type_external_id_idx', '{{%user_auth_provider}}', ['type', 'external_id']);
        $this->addForeignKey('user_auth_provider_user_fk', '{{%user_auth_provider}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Table "device"
        $this->createTable('{{%device}}', [
            'id' => $primaryKeyField,
            'uuid' => $this->string(64)->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'type' => "ENUM('Mobile', 'Kiosk', 'Browser') NOT NULL",
            'name' => $this->string(64),
            'photo' => $this->string(255),
            'status' => "ENUM('Inactive', 'Active') NOT NULL",
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
            'user_id' => $this->integer()->unsigned()->notNull(),
            'device_id' => $this->integer()->unsigned(),
            'device_type' => $this->string(64)->notNull(),
            'action_type' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'promo_code' => $this->string(8),
            'status' => $this->string(64)->notNull(),
            'created_at' => $createdAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('action_type_idx', '{{%action}}', 'action_type');
        $this->createIndex('action_user_idx', '{{%action}}', 'user_id');
        $this->addForeignKey('action_user_fk', '{{%action}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Table "setting"
        $settingType = "ENUM('Input', 'Password', 'Textarea', 'Checkbox', 'Select', 'Tag', 'Image') NOT NULL";
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
            'name' => 'Admin',
        ]);

        // Add default settings
        $this->insert('{{%setting}}', [
            'title' => 'Sender Email',
            'name' => 'system_email_sender',
            'value' => 'webmaster@meetkodi.com',
            'bunch' => 'System',
            'type' => 'Input',
            'sort_order' => 11,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Require email confirmation',
            'name' => 'system_email_confirmation_require',
            'value' => '1',
            'bunch' => 'System',
            'type' => 'Checkbox',
            'sort_order' => 12,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Facebook Messenger Email',
            'name' => 'component_facebook_email',
            'value' => 'webmaster@meetkodi.com',
            'bunch' => 'Components',
            'type' => 'Input',
            'sort_order' => 21,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Facebook Messenger Password',
            'name' => 'component_facebook_password',
            'value' => '12345678',
            'bunch' => 'Components',
            'type' => 'Password',
            'sort_order' => 21,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Allow requests to API',
            'name' => 'service_api_allow_requests',
            'value' => '1',
            'bunch' => 'Devices',
            'type' => 'Checkbox',
            'sort_order' => 31,
        ]);
        $this->insert('{{%setting}}', [
            'description' => 'Global settings that will be assigned to all devices registered in Kodi ecosystem. These settings might be overwritten by specific device settings.',
            'title' => 'Min symbols to start searching',
            'name' => 'content_search_min_symbols',
            'value' => '2',
            'bunch' => 'Devices',
            'type' => 'Input',
            'sort_order' => 32,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Watermark that will be set to all photos device print',
            'name' => 'device_watermark_photo',
            'value' => 'http://backend.meetkodi.com/img/uploads/device_watermark_photo.png',
            'bunch' => 'Devices',
            'type' => 'Image',
            'sort_order' => 33,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Supported countries',
            'description' => 'List of countries user can select (i.e. when use the mobile app)',
            'name' => 'device_countries_support',
            'value' => 'Italy,Poland,Russia,Turkey,Ukraine,United Kingdom',
            'bunch' => 'Devices',
            'type' => 'Tag',
            'sort_order' => 34,
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

        // Table "action"
        $this->dropForeignKey('action_user_fk', '{{%action}}');
        $this->dropTable('{{%action}}');

        // Table "user_auth_provider"
        $this->dropForeignKey('user_auth_provider_user_fk', '{{%user_auth_provider}}');
        $this->dropTable('{{%user_auth_provider}}');

        // Table "user_auth_token"
        $this->dropForeignKey('user_auth_token_user_fk', '{{%user_auth_token}}');
        $this->dropTable('{{%user_auth_token}}');

        // Table "user_profile"
        $this->dropForeignKey('user_profile_user_fk', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');

        // Table "user"
        $this->dropTable('{{%user}}');

        // Table "promo_code"
        $this->dropTable('{{%promo_code}}');

        // Table "social_user"
        $this->dropTable('{{%social_user}}');

        // Table "setting"
        $this->dropTable('{{%setting}}');
    }
}
