<?php
namespace app\models\forms;
use yii\base\Model;

class SignupForm extends Model{

    public $username;
    public $password;
    public $email;

    public function rules() {
        return [
            [['username', 'password', 'email'], 'required', 'message' => 'Field should not be empty'],
            [['password'], 'string', 'min' => 6],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
        ];
    }

}