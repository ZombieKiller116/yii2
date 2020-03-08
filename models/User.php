<?php

namespace app\models;

use Yii;
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['email', 'password', 'access_token', 'name'], 'required'],
            [['role'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['email', 'access_token'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 15],
            [['email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'access_token' => 'Access Token',
            'role' => 'Role',
            'name' => 'Name',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->access_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
