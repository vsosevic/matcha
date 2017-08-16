<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $Id
 * @property integer $message_from
 * @property integer $message_to
 * @property string $date
 * @property string $message
 *
 * @property Users $messageFrom
 * @property Users $messageTo
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_from', 'message_to', 'message'], 'required'],
            [['message_from', 'message_to'], 'integer'],
            [['date'], 'safe'],
            [['message'], 'string'],
            [['message_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['message_from' => 'Id']],
            [['message_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['message_to' => 'Id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'message_from' => 'Message From',
            'message_to' => 'Message To',
            'date' => 'Date',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageFrom()
    {
        return $this->hasOne(Users::className(), ['Id' => 'message_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageTo()
    {
        return $this->hasOne(Users::className(), ['Id' => 'message_to']);
    }

    public static function findByMessageFrom($userId) {
        return self::findAll(['message_from' => $userId]);
    }
}
