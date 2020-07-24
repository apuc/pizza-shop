<?php

namespace app\controllers;

use app\entities\Cart;
use app\models\Product;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class CartController extends Controller
{
    public function actionAddProduct() {
        $product = $this->getProduct(Yii::$app->request->post('id'));
        $quantity = Yii::$app->request->post('quantity');
        if(!$quantity && $quantity<0)
            throw new HttpException(403, 'Quantity must be bigger then 0');
        $cart = new Cart();
        $cart->addProduct($product, $quantity);
        return json_encode($cart->getProducts());
    }

    public function actionIncrementProduct() {
        $product = $this->getProduct(Yii::$app->request->post('id'));
        $cart = new Cart();
        $cart->addProduct($product, 1);
        return json_encode([
            'quantity' => $cart->getQuantity($product->id),
            'total_price' => $cart->getTotalProductPrice($product)
        ]);
    }

    public function actionDecrementProduct() {
        $product = $this->getProduct(Yii::$app->request->post('id'));
        $cart = new Cart();
        $cart->decreaseProduct($product, 1);
        return json_encode([
            'quantity' => $cart->getQuantity($product->id),
            'total_price' => $cart->getTotalProductPrice($product)
        ]);
    }

    public function actionDeleteProduct() {
        $cart = new Cart();
        $cart->deleteProduct(Yii::$app->request->post('id'));
        return true;
    }

    public function actionGetHeaderInfo() {
        $cart = new Cart();
        return json_encode([
            'total_quantity' => count($cart->getProducts()),
            'total_price' => $cart->getTotalPrice()
        ]);
    }

    /**
     * @param $id
     * @return Product
     * @throws HttpException
     */
    public function getProduct($id) {
        $product = Product::findOne(Yii::$app->request->post('id'));
        if(!$product)
            throw new HttpException(403, 'Product not found');
        return $product;
    }
}
