<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "interests".
 *
 * @property integer $Id
 * @property string $interest
 *
 * @property Userstointerests[] $userstointerests
 */
class Interests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'interests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interest'], 'required'],
            [['interest'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'interest' => 'Interest',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserstointerests()
    {
        return $this->hasMany(Userstointerests::className(), ['interests_id' => 'Id']);
    }


    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['Id' => 'users_id'])
      ->viaTable('Userstointerests', ['interests_id' => 'Id']);
    }

    public function getInterestByName($name) {
        return self::findOne(['interest' => $name]);
    }
}
