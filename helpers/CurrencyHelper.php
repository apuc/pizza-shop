<?php


namespace app\helpers;


use app\models\Product;
use Yii;

class CurrencyHelper
{
    const CURRENCY_USD = 0;
    const CURRENCY_EUR = 1;

    const COEFFICIENT = 1.16;

    public static $currencies = ['USD', 'EUR'];

    public static function setCurrency($id) {
        if(isset(CurrencyHelper::$currencies[$id]))
            Yii::$app->session->set('currency', $id);
    }

    public static function getCurrency() {
        return Yii::$app->session->get('currency', self::CURRENCY_USD);
    }

    public static function getCurrencyName() {
        if(isset(self::$currencies[self::getCurrency()]))
            return self::$currencies[self::getCurrency()];
        return self::$currencies[self::CURRENCY_USD];
    }

    public static function getPrice($price) {
        if ((int)self::getCurrency() === self::CURRENCY_EUR)
            return round($price * self::COEFFICIENT, 2);
        return $price;
    }
}
