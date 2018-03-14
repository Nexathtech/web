<?php

use yii\db\Migration;

/**
 * Class m180313_213430_ad_image_table
 */
class m180313_213430_ad_image_table extends Migration
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
        $statusField = "ENUM('Active', 'Inactive') NOT NULL";

        $this->createTable('{{%ad_image}}', [
            'id' => $primaryKeyField,
            'user_id' => $this->integer()->unsigned()->notNull(),
            'image' => $this->text(),
            'location_latitude' => $this->string(64)->null(),
            'location_longitude' => $this->string(64)->null(),
            'status' => $statusField,
            'created_at' => $createdAtField,
            'updated_at' => $updatedAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('ad_image_user_idx', '{{%ad_image}}', 'user_id');
        $this->createIndex('ad_image_status_idx', '{{%ad_image}}', 'status');
        $this->addForeignKey('ad_image_user_fk', '{{%ad_image}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('ad_image_user_fk', '{{%user_auth_provider}}');
        $this->dropTable('{{%ad_image}}');
    }
}
