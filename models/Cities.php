<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property integer $Id
 * @property string $city
 *
 * @property Users[] $users
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city'], 'required'],
            [['city'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'city' => 'City',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['city_id' => 'Id']);
    }

    public static function getCityByName($name) {
        return self::findOne(['city' => $name]);
    }

    public static function getCityById($Id) {
        return self::findOne(['Id' => $Id]);
    }

    public static function getCityToStringById($Id) {
        return self::findOne(['Id' => $Id])['city'];
    }
}
