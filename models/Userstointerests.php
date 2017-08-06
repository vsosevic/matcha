<?php

namespace app\models;

use Yii;
use app\models\Interests;

/**
 * This is the model class for table "userstointerests".
 *
 * @property integer $Id
 * @property integer $users_id
 * @property integer $interests_id
 *
 * @property Users $users
 * @property Interests $interests
 */
class Userstointerests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userstointerests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id', 'interests_id'], 'required'],
            [['users_id', 'interests_id'], 'integer'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'Id']],
            [['interests_id'], 'exist', 'skipOnError' => true, 'targetClass' => Interests::className(), 'targetAttribute' => ['interests_id' => 'Id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'users_id' => 'Users ID',
            'interests_id' => 'Interests ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['Id' => 'users_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterests()
    {
        return $this->hasOne(Interests::className(), ['Id' => 'interests_id']);
    }

    public static function getInterestsToStringByUserId($user_id) {
        $usersToInterests = self::find()->where(['users_id' => $user_id])->all();
        $interests = "";
        foreach ($usersToInterests as $interest) {
            $interests .= Interests::findOne($interest->interests_id)->interest . " ";
        }
        return $interests;
    }
}
