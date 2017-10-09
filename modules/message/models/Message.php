<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\modules\message\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use kirillantv\swap\models\Item;

/**
 * @property int $id ID
 * @property int $user_id ID of user who creates message
 * @property string $message Body of message
 * @property varchar $ip IP of user
 * @property string $created_at The time of the message
 * @property int $status Status of the message
 * @propery int $conversation_id ID of conversation where message was created
 */

class Message extends \yii\db\ActiveRecord
{
	const SCENARIO_CONVERSATION = 'conversation';
	
	const STATUS_NEW = 0;
	const STATUS_READ = 1;
	/**
     * @inheritdoc
     */
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CONVERSATION] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }
    public static function tableName()
    {
        return '{{%swap_message}}';
    }
    
    public function behaviors()
    {
    	return [
    		[
    			'class' => BlameableBehavior::classname(),
    			'createdByAttribute' => 'user_id',
    			'updatedByAttribute' => false
    			],
    		[
    			'class' => AttributeBehavior::classname(),
    			'attributes' => [ActiveRecord::EVENT_BEFORE_INSERT => 'ip'],
    			'value' => Yii::$app->request->userIP,
    			],
    		[
    			'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
                'value' => new Expression('NOW()'),
    			]
    		];
    }
     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conversation_id', 'message'], 'required'],
            [['conversation_id', 'status'], 'integer'],
            [['message'], 'string'],
            [['status'], 'default', 'value' => self::STATUS_NEW]
        ];
    }
    
    public static function find()
    {
        return new \kirillantv\swap\modules\message\models\query\MessageQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
    
    public function getConversation()
    {
    	return $this->hasOne(Conversation::classname(), ['id' => 'conversation_id']);
    }
    
    /**
     * Checks whether $this message object was created by current user
     * 
     * @return bool
     */
    public function isMe()
    {
    	return $this->user_id == Yii::$app->user->identity->id ? true : false;
    }
}