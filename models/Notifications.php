<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property integer $Id
 * @property integer $users_id
 * @property integer $notification_type
 * @property integer $seen
 *
 * @property Users $users
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id', 'notification_type'], 'required'],
            [['users_id', 'notification_type', 'seen'], 'integer'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'Id']],
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
            'notification_type' => 'Notification Type',
            'seen' => 'Seen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['Id' => 'users_id']);
    }

}
