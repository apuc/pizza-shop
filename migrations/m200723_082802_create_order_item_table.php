<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_item}}`.
 */
class m200723_082802_create_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_item}}', [
            'product_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull()
        ]);
        $this->addPrimaryKey('order_item_pk', '{{%order_item}}', ['product_id', 'order_id']);
        $this->addForeignKey('order_item_product', '{{%order_item}}', 'product_id', '{{%product}}', 'id');
        $this->addForeignKey('order_item_order', '{{%order_item}}', 'order_id', '{{%order}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('order_item_product', '{{%order_item}}');
        $this->dropForeignKey('order_item_order', '{{%order_item}}');
        $this->dropTable('{{%order_item}}');
    }
}
