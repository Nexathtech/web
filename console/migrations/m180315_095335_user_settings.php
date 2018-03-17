<?php

use yii\db\Migration;

/**
 * Class m180315_095335_user_settings
 */
class m180315_095335_user_settings extends Migration
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
        $writableField = "ENUM('1', '0') NOT NULL";
        $settingType = "ENUM('Input', 'Password', 'Textarea', 'Checkbox', 'Select', 'Tag', 'Image') NOT NULL";

        // Table "user_settings"
        $this->createTable('{{%user_settings}}', [
            'id' => $primaryKeyField,
            'user_id' => $this->integer()->unsigned()->notNull(),
            'title' => $this->string(64)->notNull(),
            'key' => $this->string(64)->notNull(),
            'value' => $this->text(),
            'type' => $settingType,
            'options' => $this->text()->null(),
            'writable' => $writableField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('user_settings_user_idx', '{{%user_settings}}', 'user_id');
        $this->addForeignKey('user_settings_user_fk', '{{%user_settings}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Insert data into the table
        $users = \kodi\common\models\user\User::find()->select(['id'])->all();
        foreach ($users as $user) {
            /* @var $user \kodi\common\models\user\User */
            $this->insert('{{%user_settings}}', [
                'user_id' => $user->id,
                'title' => 'Language',
                'key' => 'users_language',
                'value' => \kodi\common\enums\Language::ENGLISH,
                'type' => \kodi\common\enums\setting\Type::SELECT,
                'options' => \yii\helpers\Json::encode(\kodi\common\enums\Language::listData()),
                'writable' => 1,
            ]);

            $this->insert('{{%user_settings}}', [
                'user_id' => $user->id,
                'title' => 'Max prints amount',
                'key' => 'users_max_prints_amount',
                'value' => null,
                'type' => \kodi\common\enums\setting\Type::INPUT,
                'writable' => 0,
            ]);
        }

        // Add a fields to global settings
        $this->insert('{{%setting}}', [
            'title' => 'Max prints amount',
            'description' => 'Amount of photos users can print by default. 0 = unlimited',
            'name' => 'users_max_prints_amount',
            'value' => '1',
            'bunch' => 'Users',
            'type' => 'Input',
            'sort_order' => 61,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Max prints amount for brands',
            'description' => 'Amount of photos Brands can print by default. 0 = unlimited',
            'name' => 'users_max_prints_amount_brands',
            'value' => '2',
            'bunch' => 'Users',
            'type' => 'Input',
            'sort_order' => 62,
            'access_level' => 10,
        ]);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Table "user_settings"
        $this->dropForeignKey('user_settings_user_fk', '{{%user_settings}}');
        $this->dropTable('{{%user_settings}}');

        $this->delete('{{%setting}}', ['name' => 'users_max_prints_amount']);
        $this->delete('{{%setting}}', ['name' => 'users_max_prints_amount_brands']);
    }
}
