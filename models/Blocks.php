<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Blocks".
 *
 * @property string $Id
 * @property string $block_from
 * @property string $block_to
 *
 * @property Users $blockFrom
 * @property Users $blockTo
 */
class Blocks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Blocks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['block_from', 'block_to'], 'required'],
            [['block_from', 'block_to'], 'integer'],
            [['block_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['block_from' => 'Id']],
            [['block_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['block_to' => 'Id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'block_from' => 'Block From',
            'block_to' => 'Block To',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockFrom()
    {
        return $this->hasOne(Users::className(), ['Id' => 'block_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockTo()
    {
        return $this->hasOne(Users::className(), ['Id' => 'block_to']);
    }
}
