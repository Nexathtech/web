<?php

use yii\db\Migration;

/**
 * Class m190327_091529_event_table
 */
class m190327_091529_event_table extends Migration
{
    /**
     * {@inheritdoc}
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
        $timeStampField = 'TIMESTAMP NULL';
        $statusField = "ENUM('Active', 'Inactive') NOT NULL";

        $this->createTable('{{%event}}', [
            'id' => $primaryKeyField,
            'title' => $this->string(64)->notNull(),
            'description' => $this->text(),
            'logo' => $this->string(255),
            'location_latitude' => $this->decimal(11, 8)->notNull(),
            'location_longitude' => $this->decimal(11, 8)->notNull(),
            'location_radius' => $this->integer()->notNull(),
            'users_max_prints_amount' => $this->integer()->defaultValue(10),
            'starts_at' => $timeStampField,
            'ends_at' => $timeStampField,
            'status' => $statusField,
            'created_at' => $timeStampField,
            'updated_at' => $timeStampField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
