<?php

namespace app\models\forms;

class ConfirmForm extends \yii\base\Model
{
    public $token;
    public $captcha;

    public function rules()
    {
        return [
            [['token', 'captcha'], 'required'],
            ['captcha', 'captcha', 'caseSensitive' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'token' => 'Код',
            'captcha' => 'Капча'
        ];
    }
}