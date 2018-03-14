<?php

use yii\db\Migration;

/**
 * Class m180314_142645_user_profile_location_fields
 */
class m180314_142645_user_profile_location_fields extends Migration
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

        $this->addColumn('{{%user_profile}}', 'location_latitude', $this->string('64'));
        $this->addColumn('{{%user_profile}}', 'location_longitude', $this->string('64'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_profile}}', 'location_latitude');
        $this->dropColumn('{{%user_profile}}', 'location_longitude');
    }
}
