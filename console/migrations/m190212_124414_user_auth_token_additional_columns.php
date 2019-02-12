<?php

use yii\db\Migration;

/**
 * Class m190212_124414_user_auth_token_additional_columns
 */
class m190212_124414_user_auth_token_additional_columns extends Migration
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

        $this->addColumn('{{%user_auth_token}}', 'log_user_in', $this->boolean()->after('token_refresh')->defaultValue(false));
        $this->addColumn('{{%user_auth_token}}', 'redirect_url', $this->string(255)->after('log_user_in')->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{%user_auth_token}}', 'log_user_in');
        $this->dropColumn('{{%user_auth_token}}', 'redirect_url');
    }
}
