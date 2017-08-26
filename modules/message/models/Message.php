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

class Message extends \yii\db\ActiveRecord
{
	const SCENARIO_CONVERSATION = 'conversation';
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
    			'createdByAttribute' => 'from',
    			'updatedByAttribute' => false
    			],
    		[
    			'class' => AttributeBehavior::classname(),
    			'attributes' => [ActiveRecord::EVENT_BEFORE_INSERT => 'hash'],
    			'value' => md5(uniqid(rand(), true)),
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
            [['to', 'item_id', 'message'], 'required'],
            [['to', 'item_id'], 'integer'],
            [['message'], 'string'],
            [['to'], 'exist', 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['to' => 'id']]
        ];
    }
    
    public static function find()
    {
        return new \kirillantv\swap\modules\message\models\query\MessageQuery(get_called_class());
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
    
    public function compose(Item $item = null, $to = null)
    {
    	if ($this->scenario == self::SCENARIO_CONVERSATION)
    	{
    		$this->to = $to;
			$this->item_id = $item->id;	
    	}
    	if ($this->scenario == self::SCENARIO_DEFAULT)
    	{
    		$this->to = $item->author->id;
			$this->item_id = $item->id;	
    	}
		
    }
    
    public function getInterlocutor()
    {
    	return $this->sender->id == Yii::$app->user->identity->id ? $this->recipient->username : $this->sender->username;
    }
}