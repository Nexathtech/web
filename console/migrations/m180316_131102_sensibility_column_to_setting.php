<?php

use yii\db\Migration;

/**
 * Class m180316_131102_sensibility_column_to_setting
 */
class m180316_131102_sensibility_column_to_setting extends Migration
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function safeUp()
    {
        // Database-specific settings
        $dbDriver = $this->db->getDriverName();
        if ($dbDriver !== 'mysql') {
            throw new Exception('Selected database driver is not supported!');
        }

        $this->addColumn('{{%setting}}', 'access_level', $this->integer()->after('sort_order')->defaultValue(100));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%setting}}', 'access_level');
    }
}
