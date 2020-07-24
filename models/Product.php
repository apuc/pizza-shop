<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property float|null $price
 * @property string|null $image_url
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_shown
 *
 * @property OrderItem[] $orderItems
 * @property Order[] $orders
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['image_url'], 'string', 'max' => 255],
            [['is_shown'], 'boolean'],
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
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'image_url' => 'Image Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_shown' => 'Is Shown',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'order_id'])->viaTable('order_item', ['product_id' => 'id']);
    }
}
