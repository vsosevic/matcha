<?php

namespace app\models;

use Yii;
use app\models\Users;
/**
 * This is the model class for table "Users".
 *
 * @property string $Id
 * @property string $user_name
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property integer $gender
 * @property integer $orientation
 * @property string $about
 * @property string $auth_key
 * @property string $registration_date
 */
class UserSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'first_name', 'last_name', 'password'], 'required'],
            [['gender', 'orientation'], 'integer'],
            [['about'], 'string'],
            [['registration_date'], 'safe'],
            [['user_name', 'first_name', 'last_name', 'email', 'auth_key'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'user_name' => 'User Name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'gender' => 'Gender',
            'orientation' => 'Orientation',
            'about' => 'About',
            'auth_key' => 'Auth Key',
            'registration_date' => 'Registration Date',
        ];
    }

    public function test() {
        $posts = Yii::$app->db->createCommand('SELECT email FROM users WHERE user_name=:name')
        ->bindValue(':name', Yii::$app->user->identity->user_name)
        ->queryOne();
        return $posts['email'];
    }
}
