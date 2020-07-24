<?php


use app\entities\Cart;
use app\models\Product;
use yii\web\View;

/* @var $this View */
/* @var $products Product[] */
/* @var $cart Cart */

$this->title = 'Cart';
?>
<?php if($products):?>
    <?php foreach ($products as $product):?>
        <div class="product horizontal">
            <div class="img-container">
                <img class="product__img" src="<?=$product->image_url?>"/>
            </div>
            <div class="product__info">
                <h3 class="product__title"><?=$product->name?></h3>
                <p class="product__description"><?=$product->description?></p>
            </div>
            <div class="product__footer">
                <div class="counter" data-id="<?=$product->id?>">
                    <button type="button" class="btn counter-btn jsDecrement">-</button>
                    <span class="number jsNumber"><?=$cart->getQuantity($product->id)?></span>
                    <button type="button" class="btn counter-btn jsIncrement">+</button>
                    <buttton type="button" class="counter-btn trash">
                        <i class="fas fa-trash-alt"></i>
                    </buttton>
                </div>
                <p class="product__price">Price: <span class="jsProductTotal"><?=$cart->getTotalProductPrice($product)?></span> USD</p>
            </div>
        </div>
    <?php endforeach;?>
    <?=\yii\helpers\Html::a('Checkout', \yii\helpers\Url::toRoute('/site/checkout'), ['class'=>'btn btn-info checkout'])?>
<?php else: ?>
<p>Your cart is empty</p>
<?php endif ?>
