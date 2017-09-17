<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Visites".
 *
 * @property string $Id
 * @property string $visit_from
 * @property string $visit_to
 * @property string $date
 *
 * @property Users $visitFrom
 * @property Users $visitTo
 */
class Visites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Visites';
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
}
