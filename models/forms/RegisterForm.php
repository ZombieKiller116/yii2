<?php

namespace app\models\forms;

class RegisterForm extends \yii\base\Model
{
    public $email;
    public $password;
    public $name;
    public $captcha;

    public function rules()
    {
        return [
            [['email', 'name', 'password', 'captcha'], 'required'],
            ['email', 'email'],
            ['name', 'string', 'length' => [2, 15]],
            ['password', 'string', 'length' => [6, 80]],
            ['captcha', 'captcha', 'caseSensitive' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'name' => 'Имя',
            'password' => 'Пароль',
            'captcha' => 'Капча'
        ];
    }
}