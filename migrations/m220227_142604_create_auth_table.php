<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m220227_142604_create_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'iser_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'sourse_id' => $this->string()->notNull(),
        ]);

        

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-auth-iser_id}}',
            '{{%auth}}',
            'iser_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-auth-iser_id}}',
            '{{%auth}}'
        );

        

        $this->dropTable('{{%auth}}');
    }
}
