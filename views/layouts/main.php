<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\helpers\CurrencyHelper;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://kit.fontawesome.com/8df711220b.js" crossorigin="anonymous"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Pizza shop',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $cart = new \app\entities\Cart();
    ?>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
        <?=Html::a('Orders', \yii\helpers\Url::toRoute('/site/orders'), ['class' => 'orders'])?>
    <?php endif ?>
    <?=Html::dropDownList(
            'currency',
            CurrencyHelper::getCurrency(),
            CurrencyHelper::$currencies,
            ['id' => 'currency_dropdown']
    )?>
    <?php if(Yii::$app->user->isGuest):?>
    <a href="<?=\yii\helpers\Url::toRoute('/site/login')?>">Login</a>
    <a href="<?=\yii\helpers\Url::toRoute('/site/signup')?>">Signup</a>
    <?php else:?>
        <span><?=Yii::$app->user->identity->username?></span>
        <?=Html::beginForm(\yii\helpers\Url::toRoute('/site/logout'))?>
            <?=Html::submitButton('logout', ['class' => 'custom-btn'])?>
        <?=Html::endForm()?>
    <?php endif ?>
    <span id="totalQuantity" class="mr5"><?=$cart->getProductsCount()?></span>  products. Total: <span id="totalPrice" class="mr5"><?=$cart->getTotalPrice()?></span> <?=CurrencyHelper::getCurrencyName()?>
    <?php
    echo Html::a('<i class="fas fa-shopping-cart cart-icon"></i>', \yii\helpers\Url::toRoute('/site/cart'));
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
