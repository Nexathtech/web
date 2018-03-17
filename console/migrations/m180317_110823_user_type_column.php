<?php

use yii\db\Migration;

/**
 * Class m180317_110823_user_type_column
 */
class m180317_110823_user_type_column extends Migration
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

        $typeField = "ENUM('Simple', 'Brand') NOT NULL AFTER role";
        $this->addColumn('{{%user}}', 'type', $typeField);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'type');
    }
}
