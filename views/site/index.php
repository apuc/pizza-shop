<?php


use app\helpers\CurrencyHelper;
use app\models\Product;

/* @var $this yii\web\View */
/* @var $products Product[] */

$this->title = 'Pizza shop';
?>
<div class="site-index products-container">
    <?php foreach ($products as $product):?>
        <div class="product">
            <h3 class="product__title"><?=$product->name?></h3>
            <div class="img-container">
                <img class="product__img" src="<?=$product->image_url?>"/>
            </div>
            <p class="product__description"><?=$product->description?></p>
            <div class="product__footer">
                <p class="product__price">Price: <?=CurrencyHelper::getPrice($product->price) . ' ' . CurrencyHelper::getCurrencyName()?></p>
                <input type="number" min="0">
                <button data-id="<?=$product->id?>" type="button" class="add-to-cart-btn js_add_product">+</button>
            </div>
        </div>
    <?php endforeach;?>
</div>
