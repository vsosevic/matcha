<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property integer $Id
 * @property integer $like_from
 * @property integer $like_to
 * @property string $date
 *
 * @property Users $likeFrom
 * @property Users $likeTo
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['like_from', 'like_to'], 'required'],
            [['like_from', 'like_to'], 'integer'],
            [['date'], 'safe'],
            [['like_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['like_from' => 'Id']],
            [['like_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['like_to' => 'Id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'like_from' => 'Like From',
            'like_to' => 'Like To',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikeFrom()
    {
        return $this->hasOne(Users::className(), ['Id' => 'like_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikeTo()
    {
        return $this->hasOne(Users::className(), ['Id' => 'like_to']);
    }

    /**
     * Returns your likes for other users
     */
    public static function getLikesForUser() {
        $likes = array();

        $queryLikes = Self::find(['like_to'])
            ->where(['like_from' => Yii::$app->user->identity->Id])
            ->asArray()
            ->all();

        foreach ($queryLikes as $value) {
            $likes[] = $value['like_to'];
        }

        return $likes;
    }

    /**
     * Returns users who've liked you
     */
    public static function getLikesFromUsers() {
        $likes = array();

        $queryLikes = Self::find(['like_from'])
            ->where(['like_to' => Yii::$app->user->identity->Id])
            ->asArray()
            ->all();

        foreach ($queryLikes as $value) {
            $likes[] = $value['like_from'];
        }

        return $likes;
    }

}
