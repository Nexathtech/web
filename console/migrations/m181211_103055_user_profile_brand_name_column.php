<?php

use yii\db\Migration;

/**
 * Class m181211_103055_user_profile_brand_name_column
 */
class m181211_103055_user_profile_brand_name_column extends Migration
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

        $this->addColumn('{{%user_profile}}', 'brand_name', $this->string('64')->after('surname'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_profile}}', 'brand_name');
    }
}
