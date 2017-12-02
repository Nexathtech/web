<?php

use yii\db\Migration;

/**
 * Class m171130_114649_order_table
 */
class m171130_114649_order_table extends Migration
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
        $statusField = "ENUM('Waiting', 'Pending', 'Completed', 'Canceled') NOT NULL";

        $this->createTable('{{%order}}', [
            'id' => $primaryKeyField,
            'name' => $this->string(64)->notNull(),
            'surname' => $this->string(64)->notNull(),
            'email' => $this->string(64)->notNull(),
            'company' => $this->string(64),
            'country' => $this->string(64)->notNull(),
            'city' => $this->string(64)->notNull(),
            'state' => $this->string(64),
            'address' => $this->string(255)->notNull(),
            'postcode' => $this->string(64),
            'color' => $this->string(64)->notNull(),
            'quantity' => $this->integer()->unsigned()->notNull(),
            'payment_type' => $this->string(255)->notNull(),
            'status' => $statusField,
            'created_at' => $createdAtField,
            'updated_at' => $updatedAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('order_status_idx', '{{%order}}', 'status');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }

}
