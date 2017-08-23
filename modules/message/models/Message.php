<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\modules\message\models;

use Yii;
use kirillantv\swap\models\Item;

class Message extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%swap_message}}';
    }
    
     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hash', 'from', 'to', 'item_id', 'message'], 'required'],
            [['from', 'to', 'item_id'], 'integer'],
            [['message'], 'string'],
            [['hash'], 'string', 'max' => 32],
            [['to'], 'exist', 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['to' => 'id']]
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'to']);
    }
    
    public function getSender()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'from']);
    }
    
    public function getItem()
    {
    	return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}