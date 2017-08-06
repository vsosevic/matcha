<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Avatars".
 *
 * @property integer $Id
 * @property integer $users_id
 * @property string $avatar1
 * @property string $avatar2
 * @property string $avatar3
 * @property string $avatar4
 * @property string $avatar5
 */
class Avatars extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Avatars';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id'], 'required'],
            [['users_id'], 'integer'],
            [['avatar1', 'avatar2', 'avatar3', 'avatar4', 'avatar5'], 'required', 'on' => 'upload-avatar'],
            [['avatar1', 'avatar2', 'avatar3', 'avatar4', 'avatar5'], 'file', 'extensions' => 'png, jpg, gif'],
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
            'avatar1' => 'Main avatar',
            'avatar2' => 'The 2nd photo',
            'avatar3' => 'The 3d photo',
            'avatar4' => 'The 4th photo',
            'avatar5' => 'The 5th photo',
        ];
    }

    public static function getAvatarsByUserId ($users_id) {
        return self::findOne(['users_id' => $users_id]);
    }
}
