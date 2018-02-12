<?php

use yii\db\Migration;

/**
 * Class m180212_181825_settings_mobile_app
 */
class m180212_181825_settings_mobile_app extends Migration
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

        $this->insert('{{%setting}}', [
            'title' => 'Amount of orders allowed',
            'description' => 'Amount of orders allowed before waiting list will be activated. 0 = unlimited',
            'name' => 'mobile_app_orders_allowed',
            'value' => '1000',
            'bunch' => 'Mobile app',
            'type' => 'Input',
            'sort_order' => 51,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['name' => 'mobile_app_orders_allowed']);
    }
}
