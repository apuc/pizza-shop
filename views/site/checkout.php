<?php


use app\entities\Cart;
use app\models\Order;
use app\models\Product;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $products Product[] */
/* @var $cart Cart */
/* @var $order Order */

$this->title = 'Checkout';
?>
<div class="order-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($order, 'client_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($order, 'client_surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($order, 'client_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($order, 'client_address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
