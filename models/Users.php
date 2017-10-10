<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $Id
 * @property string $user_name
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property integer $gender
 * @property integer $orientation
 * @property string $about
 * @property string $registration_date
 * @property integer $city_id
 * @property integer $fame_rating
 * @property integer $age
 * @property string $last_connection
 * @property integer $fake_reported
 * @property string $auth_key
 *
 * @property Blocks[] $blocks
 * @property Blocks[] $blocks0
 * @property Chat[] $chats
 * @property Chat[] $chats0
 * @property Likes[] $likes
 * @property Likes[] $likes0
 * @property Notifications[] $notifications
 * @property Cities $city
 * @property Userstointerests[] $userstointerests
 * @property Visites[] $visites
 * @property Visites[] $visites0
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $genderList = [
                '0' => '',
                '1' => 'Male',
                '2' => 'Female',
                '3' => 'Transgender',
                ];
    public $orientationList = [
                '0' => '',
                '1' => 'Heterosexual',
                '2' => 'Homosexual',
                '3' => 'Bisexual',
                ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'first_name', 'last_name', 'password', 'gender', 'orientation', 'age', 'email'], 'required'],
            [['gender', 'orientation', 'city_id', 'fame_rating', 'age', 'fake_reported'], 'integer'],
            [['age'], 'integer', 'min' => 18, 'max' => 150],
            [['about'], 'string'],
            [['registration_date', 'last_connection'], 'safe'],
            [['user_name', 'first_name', 'last_name', 'email', 'auth_key'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'Id']],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\Users'],
            ['user_name', 'unique', 'targetClass' => 'app\models\Users'],
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
            'registration_date' => 'Registration Date',
            'city_id' => 'City ID',
            'fame_rating' => 'Fame Rating',
            'age' => 'Age',
            'last_connection' => 'Last Connection',
            'fake_reported' => 'Fake Reported',
            'auth_key' => 'Auth Key',
        ];
    }

    public static function userHasFilledAcount() {
        return false;
    }

    public function hashPassword($password) {
        $this->password = hash('whirlpool', $password); //sha1($password);
    }

    public static function findByUsername ($username) {
        return self::findOne(['user_name' => $username]);
    }

    public function validatePassword ($password) {
        return $this->password === hash('whirlpool', $password);
    }

    public function getAuthKey() {
        // return $this->authKey;
        throw new \yii\base\NotSupportedException();
    }

    public function getId() {
        return $this->Id;
    }

    public function validateAuthKey($authKey) {
        // return $this->authKey === $authKey;
        throw new \yii\base\NotSupportedException();
    }
    
    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new \yii\base\NotSupportedException();
    }

    // public function saveChanges() {
    //     $this->first_name = $_POST['Users']['first_name'];
    //     $this->last_name = $_POST['Users']['last_name'];
    //     $this->gender = $_POST['Users']['gender'];
    //     $this->orientation = $_POST['Users']['orientation'];
    //     $this->about = $_POST['Users']['about'];
    //     $this->email = $_POST['Users']['email'];
    //     $this->age = $_POST['Users']['age'];
    //     self::save();
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Blocks::className(), ['block_from' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks0()
    {
        return $this->hasMany(Blocks::className(), ['block_to' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['message_from' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats0()
    {
        return $this->hasMany(Chat::className(), ['message_to' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::className(), ['like_from' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes0()
    {
        return $this->hasMany(Likes::className(), ['like_to' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::className(), ['users_id' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['Id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserstointerests()
    {
        return $this->hasMany(Userstointerests::className(), ['users_id' => 'Id']);
    }

    public function getInterests()
    {
        return $this->hasMany(Interests::className(), ['Id' => 'interests_id'])
      ->viaTable('Userstointerests', ['users_id' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisites()
    {
        return $this->hasMany(Visites::className(), ['visit_from' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisites0()
    {
        return $this->hasMany(Visites::className(), ['visit_to' => 'Id']);
    }
}
