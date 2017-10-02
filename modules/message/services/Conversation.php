<?php 
namespace kirillantv\swap\modules\message\services;

use Yii;
use yii\base\Object;
use kirillantv\swap\modules\message\models\Message;
/**
 * Если человек пишет автору, то автор достается из автора айтема, а если автор отвечает человеку, то человек берется из отвечаемого сообщения.
 */
class Conversation extends Object
{
	public $item_id;
	
	public $participants;
	
	public function getMe()
	{
		return Yii::$app->user->identity->id;
	}
	
	/**
	 * Return last message. For info purposes.
	 * 
	 * @return kirillantv\swap\modules\message\models\Message Last message object;
	 */
	public function getInfo()
	{
		return Message::find()->where(['item_id' => $this->item_id])->andwhere(['from' => $this->participants])->andWhere(['to' => $this->participants])->one();
	}
	
	/**
	 * Return username of interlocutor
	 * 
	 * @return string Username of interlocutor
	 */
	public function getInterlocutorName()
    {
    	return $this->info->sender->id == Yii::$app->user->identity->id ? $this->info->recipient->username : $this->info->sender->username;
    }
    
    /**
     * Return array of kirillantv\swap\modules\message\models\Message objects for current item and users
     * 
     * @return array kirillantv\swap\modules\message\models\Message;
     */
    public function getMessages()
    {
    	return Message::find()->where(['item_id' => $this->item_id])->andwhere(['from' => $this->participants])->andWhere(['to' => $this->participants])->orderBy(['created_at' => SORT_ASC])->all();
    }
}