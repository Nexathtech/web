<?php

use yii\db\Migration;

/**
 * Class m190101_173116_order_total_column_change
 */
class m190101_173116_order_total_column_change extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {
        // Database-specific settings
        $dbDriver = $this->db->getDriverName();
        if ($dbDriver !== 'mysql') {
            throw new Exception('Selected database driver is not supported!');
        }

        $this->alterColumn('{{%order}}', 'total', $this->decimal(10, 2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%order}}', 'total', $this->float());
    }
}
