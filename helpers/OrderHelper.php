<?php

namespace app\helpers;

use app\models\OrderItem;
use app\models\Product;
use yii\db\ActiveRecord;

class OrderHelper
{
    /**
     * @return Product|ActiveRecord|null
     */
    public static function getDelivery() {
        return Product::find()->where(['name' => 'Delivery'])->one();
    }

    /**
     * @param int $order_id
     * @return bool
     */
    public static function attachDeliveryToOrder($order_id) {
        $delivery = self::getDelivery();
        if( $delivery ) {
            $order_item = new OrderItem();
            $order_item->product_id = $delivery->id;
            $order_item->order_id = $order_id;
            $order_item->quantity = 1;
            if( $order_item->save() ) {
                return true;
            }
            return false;
        }
        return false;
    }
}