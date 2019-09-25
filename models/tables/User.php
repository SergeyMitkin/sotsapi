<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $auth_token
 * @property string $date_create
 * @property string $date_update
 * @property string $active
 * @property string $name
 * @property string $second_name
 * @property string $last_name
 * @property string $personal_phone
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'auth_token'], 'required'],
            [['date_create', 'date_update'], 'safe'],
            [['email', 'password', 'auth_token'], 'string', 'max' => 255],
            [['active'], 'string', 'max' => 1],
            [['name', 'second_name', 'last_name'], 'string', 'max' => 300],
            [['personal_phone'], 'string', 'max' => 20],
            [['email'], 'unique'],
            [['auth_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'auth_token' => 'Auth Token',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'active' => 'Active',
            'name' => 'Name',
            'second_name' => 'Second Name',
            'last_name' => 'Last Name',
            'personal_phone' => 'Personal Phone',
        ];
    }
}
