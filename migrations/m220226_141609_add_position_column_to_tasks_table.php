<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tasks}}`.
 */
class m220226_141609_add_position_column_to_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tasks}}', 'lat', $this->char(24));
        $this->addColumn('{{%tasks}}', 'long', $this->char(24));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tasks}}', 'lat');
        $this->dropColumn('{{%tasks}}', 'long');
    }
}
