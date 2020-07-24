<?php

namespace app\controllers;

use app\entities\Cart;
use app\helpers\CurrencyHelper;
use app\helpers\OrderHelper;
use app\models\forms\LoginForm;
use app\models\forms\SignupForm;
use app\models\Order;
use app\models\OrderItem;
use app\models\Product;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $products = Product::find()->where(['is_shown'=>true])->all();
        return $this->render('index', [
            'products' => $products
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionCart()
    {
        $cart = new Cart();
        $products = $cart->getProductModels();
        return $this->render('cart', [
            'products' => $products,
            'cart' => $cart
        ]);
    }

    /**
     * Displays checkout page.
     *
     * @return string
     */
    public function actionCheckout()
    {
        $cart = new Cart();
        $products = $cart->getProductModels();
        $order = new Order();
        if($order->load(Yii::$app->request->post()) && $order->save()) {
            foreach ($cart->getProductModels() as $product) {
                $order_item = new OrderItem();
                $order_item->product_id = $product->id;
                $order_item->order_id = $order->id;
                $order_item->quantity = $cart->getQuantity($product->id);
                $order_item->save();
            }
            OrderHelper::attachDeliveryToOrder($order->id);
            $cart->clear();
            return $this->redirect('/site/success');
        }
        return $this->render('checkout', [
            'products' => $products,
            'cart' => $cart,
            'order' => $order
        ]);
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionOrders()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()
        ]);
        return $this->render('orders', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionChangeCurrency()
    {
        CurrencyHelper::setCurrency(Yii::$app->request->post('id'));
        return true;
    }

    public function actionSignup(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SignupForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->setPassword($model->password);
            $user->generateAuthKey();
            if($user->save()){
                return $this->goHome();
            }
        }
        return $this->render('signup', compact('model'));
    }
}
