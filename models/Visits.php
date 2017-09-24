<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Visits".
 *
 * @property string $Id
 * @property string $visit_from
 * @property string $visit_to
 * @property string $date
 *
 * @property Users $visitFrom
 * @property Users $visitTo
 */
class Visits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Visits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visit_from', 'visit_to'], 'required'],
            [['visit_from', 'visit_to'], 'integer'],
            [['date'], 'safe'],
            [['visit_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['visit_from' => 'Id']],
            [['visit_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['visit_to' => 'Id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'visit_from' => 'Visit From',
            'visit_to' => 'Visit To',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitFrom()
    {
        return $this->hasOne(Users::className(), ['Id' => 'visit_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitTo()
    {
        return $this->hasOne(Users::className(), ['Id' => 'visit_to']);
    }

    /**
     * @return @string separated with comas of users ids "2,4,6,..."
     */
    public static function getVisitsFromUsers() {
        $visitUsers = array();

        $visits = Self::find()
        ->where(['visit_to' => Yii::$app->user->identity->Id])
        ->asArray()
        ->all();

        foreach ($visits as $visit) {
            $visitUsers[] = $visit['visit_from'];
        }

        return $visitUsers;
    }
    
}
