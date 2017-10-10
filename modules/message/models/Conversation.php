<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\modules\message\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use kirillantv\swap\models\Item;
/**
 * @property int $id ID
 * @property int $user_one ID of first user
 * @property int $user_two ID of second user
 * @property int $item_id ID of item
 * @property long $created_at Date and time when conversation was created
 */
 
class Conversation extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return '{{%swap_conversation}}';
	}
	
	public function behaviors()
	{
		return 
		[
			[
				'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
                'value' => new Expression('NOW()'),
				],
			[
				'class' => BlameableBehavior::classname(),
    			'createdByAttribute' => 'user_two',
    			'updatedByAttribute' => false
				]
		];
	}
	
	public function rules()
	{
		return 
		[
			[['item_id'], 'required'],
			[['item_id'], 'integer'],
			[['item_id'], 'exist', 'skipOnError' => false, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
			[['user_one'], 'default', 'value' => function($model){ 
				return Item::findOne($this->item_id)->author->id;
			}]
		];
	}
	
	public static function getConversation($item_id = null, $c_id = null)
	{
		if ($item_id != null)
		{
			$item = Item::findOne($item_id);
		}
		
		$conversation = null;
		
		if ($c_id != null)
		{
			
			$conversation = self::find()->where(['id' => $c_id])->with('item', 'messages', 'interlocutor')->one();
		}
		else
		{
			$conversation = self::find()->with('item', 'messages', 'interlocutor')
	                ->where(['user_one' => [Yii::$app->user->id, $item->author->id]])
	                ->andWhere(['user_two' => [Yii::$app->user->id, $item->author->id]])
	                ->andWhere(['item_id' => $item->id])->one();
		}
		if (!$conversation)
		{
			$conversation = new self(['item_id' => $item->id]);
			$conversation->save();
		}
		return $conversation;
	}
	
	public function getTotalCount()
	{
		return Message::find()->where(['conversation_id' => $this->id])->count();
	}
	
	public function getNotReadCount()
	{
		return Message::find()->where(['conversation_id' => $this->id, 'user_id' => $this->interlocutor->id])->andWhere(['status' => Message::STATUS_NEW])->count();
	}
	
	public function getLastMessage()
	{
		return Message::find()->where(['conversation_id' => $this->id])->orderBy(['created_at' => SORT_DESC])->one();
	}
	public function getMessages()
	{
		return $this->hasMany(Message::classname(), ['conversation_id' => 'id'])->with([
			'user' => function($query){
				return $query->select(['id', 'username']);
		}
		]);
	}
	
	public function getItem()
	{
		return $this->hasOne(Item::classname(), ['id' => 'item_id']);
	}
	
	public function getUserOne()
	{
		return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_one']);
	}
	
	public function getUserTwo()
	{
		return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_two']);
	}
	
	public function getInterlocutor()
	{
		return $this->hasOne(Yii::$app->user->identityClass, ['id' => Yii::$app->user->id == $this->user_one ? 'user_two' : 'user_one']);
	}
}