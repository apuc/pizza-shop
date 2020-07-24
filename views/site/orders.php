<?php


use app\helpers\CurrencyHelper;
use app\models\Order;

/* @var $this yii\web\View */
/* @var $orders Order[] */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Pizza shop';
?>
<div class="site-index products-container">
    <div class="product order">
        <p>Name</p>
        <p>Surname</p>
        <p>Address</p>
        <p>Email</p>
        <p>Total price</p>
        <p>Products</p>
    </div>
    <?php /** @var Order $order */
    foreach ($dataProvider->getModels() as $order):?>
        <div class="product order">
            <p class="client-name"><?=$order->client_name?></p>
            <p class="client-surname"><?=$order->client_surname?></p>
            <p class="client-address"><?=$order->client_address?></p>
            <p class="client-email"><?=$order->client_email?></p>
            <p class="totalPrice"><?=CurrencyHelper::getPrice($order->getTotalPrice())?> <?=CurrencyHelper::getCurrencyName()?></p>
            <ul class="orderList">
                <?php foreach ($order->orderItems as $orderItem):?>
                <li><?=$orderItem->product->name . ' x' . $orderItem->quantity . ' - ' . CurrencyHelper::getPrice($orderItem->quantity * $orderItem->product->price)?> <?=CurrencyHelper::getCurrencyName()?></li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endforeach;?>
</div>
