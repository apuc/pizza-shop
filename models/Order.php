<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $client_name
 * @property string $client_surname
 * @property string $client_address
 * @property int $client_email
 * @property int $created_at
 * @property int $updated_at
 *
 * @property OrderItem[] $orderItems
 * @property Product[] $products
 */
class Order extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_name', 'client_surname', 'client_address', 'client_email'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['client_name', 'client_surname'], 'string', 'max' => 50],
            [['client_address'], 'string', 'max' => 150],
            [['client_email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_name' => 'Name',
            'client_surname' => 'Surname',
            'client_address' => 'Address',
            'client_email' => 'Email',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
     *
     * @return int
     */
    public function getTotalPrice()
    {
        $price = 0;
        foreach ($this->orderItems as $orderItem) {
            $price += $orderItem->quantity * $orderItem->product->price;
        }
        return $price;
    }

    /**
     * Gets query for [[Products]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('order_item', ['order_id' => 'id']);
    }
}
