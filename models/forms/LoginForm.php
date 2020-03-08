<?php

namespace app\models\forms;

class LoginForm extends \yii\base\Model
{
    public $email;
    public $password;
    public $captcha;

    public function rules()
    {
        return [
            [['email', 'password', 'captcha'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'length' => [6, 80]],
            ['captcha', 'captcha', 'caseSensitive' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'captcha' => 'Капча'
        ];
    }
}