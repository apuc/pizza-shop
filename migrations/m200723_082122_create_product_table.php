<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m200723_082122_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'description' => $this->text(),
            'price' => $this->decimal(10,2),
            'image_url' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
