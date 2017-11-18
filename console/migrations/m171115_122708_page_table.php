<?php

use yii\db\Migration;

/**
 * Class m171115_122708_page_table
 */
class m171115_122708_page_table extends Migration
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

        $this->createTable('{{%page}}', [
            'id' => $primaryKeyField,
            'title' => $this->string(64)->notNull(),
            'alias' => $this->string(64)->notNull(),
            'text' => $this->text(),
            'status' => $statusField,
            'script' => $this->text(),
            'meta_description' => $this->string(255),
            'meta_keywords' => $this->string(255),
            'created_at' => $createdAtField,
            'updated_at' => $updatedAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('page_status_idx', '{{%page}}', 'status');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
