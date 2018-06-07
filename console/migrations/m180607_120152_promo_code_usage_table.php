<?php

use yii\db\Migration;

/**
 * Class m180607_120152_promo_code_usage_table
 */
class m180607_120152_promo_code_usage_table extends Migration
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
        $createdAtField = 'TIMESTAMP NULL';

        $this->createTable('{{%promo_code_usage}}', [
            'id' => $primaryKeyField,
            'user_id' => $this->integer()->unsigned()->notNull(),
            'code_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $createdAtField,
            'PRIMARY KEY(`id`)',
        ], $tableOptions);
        $this->createIndex('user_id_ix', '{{%promo_code_usage}}', 'user_id');
        $this->createIndex('code_id_ix', '{{%promo_code_usage}}', 'code_id');
        $this->addForeignKey('user_id_fk', '{{%promo_code_usage}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('code_id_fk', '{{%promo_code_usage}}', 'code_id', '{{%promo_code}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_id_fk', '{{%promo_code_usage}}');
        $this->dropForeignKey('code_id_fk', '{{%promo_code_usage}}');
        $this->dropTable('{{%promo_code_usage}}');
    }
}
