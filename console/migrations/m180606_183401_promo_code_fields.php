<?php

use yii\db\Migration;

/**
 * Class m180606_183401_promo_code_fields
 */
class m180606_183401_promo_code_fields extends Migration
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

        $this->addColumn('{{%promo_code}}', 'type', "ENUM('Regular', 'Extended') NOT NULL AFTER description");
        $this->addColumn('{{%promo_code}}', 'data', $this->text()->after('type'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%promo_code}}', 'type');
        $this->dropColumn('{{%promo_code}}', 'data');
    }
}
