<?php

use yii\db\Migration;

/**
 * Class m180314_144048_order_user_id_column
 */
class m180314_144048_order_user_id_column extends Migration
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

        $this->addColumn('{{%order}}', 'user_id', $this->integer()->after('id'));
        $this->addColumn('{{%order}}', 'location_longitude', $this->string('64')->after('postcode'));
        $this->addColumn('{{%order}}', 'location_latitude', $this->string('64')->after('postcode'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'user_id');
        $this->dropColumn('{{%order}}', 'location_latitude');
        $this->dropColumn('{{%order}}', 'location_longitude');
    }
}
