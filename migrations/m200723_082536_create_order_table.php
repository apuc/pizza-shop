<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m200723_082536_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'client_name' => $this->string(50)->notNull(),
            'client_surname' => $this->string(50)->notNull(),
            'client_address' => $this->string(150)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
