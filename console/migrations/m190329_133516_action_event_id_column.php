<?php

use yii\db\Migration;

/**
 * Class m190329_133516_action_event_id_column
 */
class m190329_133516_action_event_id_column extends Migration
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

        $this->addColumn('{{%action}}', 'event_id', $this->integer()->after('user_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%action}}', 'event_id');
    }
}
