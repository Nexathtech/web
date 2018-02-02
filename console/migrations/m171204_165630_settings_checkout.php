<?php

use yii\db\Migration;

/**
 * Class m171204_165630_settings_checkout
 */
class m171204_165630_settings_checkout extends Migration
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
            'title' => 'Cost of Kodi Station, $',
            'name' => 'device_station_cost',
            'value' => '6000',
            'bunch' => 'Checkout',
            'type' => 'Input',
            'sort_order' => 41,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Station shipping cost, $',
            'name' => 'device_station_shipping_cost',
            'value' => '600',
            'bunch' => 'Checkout',
            'type' => 'Input',
            'sort_order' => 42,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Bank Beneficiary',
            'name' => 'bank_beneficiary',
            'value' => 'Kodi LLC',
            'bunch' => 'Checkout',
            'type' => 'Input',
            'sort_order' => 43,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Bank Account Number',
            'name' => 'bank_account_number',
            'value' => '2345150524',
            'bunch' => 'Checkout',
            'type' => 'Input',
            'sort_order' => 44,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Bank Swift Code',
            'name' => 'bank_swift_code',
            'value' => 'FCIBVGVG',
            'bunch' => 'Checkout',
            'type' => 'Input',
            'sort_order' => 45,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Bank Name',
            'name' => 'bank_name',
            'value' => 'Some random bank',
            'bunch' => 'Checkout',
            'type' => 'Input',
            'sort_order' => 46,
        ]);
        $this->insert('{{%setting}}', [
            'title' => 'Bank Address',
            'name' => 'bank_address',
            'value' => 'Some random bank address',
            'bunch' => 'Checkout',
            'type' => 'Input',
            'sort_order' => 47,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['name' => 'device_station_cost']);
        $this->delete('{{%setting}}', ['name' => 'device_station_shipping_cost']);
        $this->delete('{{%setting}}', ['name' => 'bank_beneficiary']);
        $this->delete('{{%setting}}', ['name' => 'bank_account_number']);
        $this->delete('{{%setting}}', ['name' => 'bank_swift_code']);
        $this->delete('{{%setting}}', ['name' => 'bank_name']);
        $this->delete('{{%setting}}', ['name' => 'bank_address']);
    }
}
