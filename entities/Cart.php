<?php

namespace app\entities;

use app\helpers\CurrencyHelper;
use app\models\Product;
use Yii;
use yii\web\HttpException;

class Cart extends \yii\base\BaseObject
{
    /**
     * @var array
     */
    private $products;

    const SESSION_KEY = 'cart';

    public function __construct($config = [])
    {
        $this->products = Yii::$app->session->get(self::SESSION_KEY, []);
        parent::__construct($config);
    }

    public function getProducts() {
        return $this->products;
    }

    public function clear() {
        Yii::$app->session->remove(self::SESSION_KEY);
        $this->products = [];
    }

    /**
     * @return int
     */
    public function getProductsCount() {
        if($this->products)
            return count($this->products);
        return 0;
    }

    public function getQuantity($product_id) {
        return isset($this->products[$product_id])?((int)$this->products[$product_id]):0;
    }

    /**
     * @param Product $product
     * @return float|int
     */
    public function getTotalProductPrice(Product $product) {
        return CurrencyHelper::getPrice($this->getQuantity($product->id) * $product->price);
    }

    /**
     * @return Product[]|null
     */
    public function getProductModels() {
        if(!$this->products)
            return null;
        return Product::find()->where(['id'=>array_keys($this->products)])->all();
    }

    public function getTotalPrice() {
        $products = $this->getProductModels();
        if(!$products)
            return 0;
        $price = 0;
        foreach ($products as $product) {
            $price += CurrencyHelper::getPrice($product->price * $this->getQuantity($product->id));
        }
        return $price;
    }

    public function addProduct($product, $quantity) {
        if( isset( $this->products[$product->id] ) ) {
            $this->products[$product->id] += $quantity;
        } else {
            $this->products[$product->id] = $quantity;
        }
        $this->toSession();
    }

    public function deleteProduct($product_id) {
        if( isset( $this->products[$product_id] ) ) {
            unset($this->products[$product_id]);
        } else throw new HttpException(403, 'Product is not in cart');
        $this->toSession();
    }

    public function decreaseProduct($product, $quantity) {
        if($this->products[$product->id] == 0)
            return 0;
        if( isset( $this->products[$product->id] ) ) {
            $this->products[$product->id] -= $quantity;
        }
        $this->toSession();
    }

    public function toSession() {
        Yii::$app->session->set(self::SESSION_KEY, $this->products);
    }
}
