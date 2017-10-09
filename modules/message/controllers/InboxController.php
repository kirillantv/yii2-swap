<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */

namespace kirillantv\swap\modules\message\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\helpers\Json;
use kirillantv\swap\modules\message\models\Message;
use kirillantv\swap\modules\message\models\Conversation;
use kirillantv\swap\models\Item;

class InboxController extends \yii\web\Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::classname(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'conversation', 'new-messages'],
						'roles' => ['@']
						]
					]
				]
			];		
	}
	
	/**
	 * Finish him
	 */
	public function actionIndex()
	{
		$conversations = Conversation::find()->where(['user_one' => Yii::$app->user->id])
		                ->orWhere(['user_two' => Yii::$app->user->id])
		                ->all();
		return $this->render('index', ['conversations' => $conversations]);
	}
	
	public function actionNewMessages($format = null)
	{
		if (Yii::$app->request->isAjax)
		{
			if ($format == 'json')
			{
				$messages = Message::find()->newMessagesForUser()->groupBy(['item_id', 'from'])->all();
				$count = Message::find()->newMessagesForUser()->count();
				return Json::encode(['messages' => $messages, 'count' => $count]);
			}
			else
			{
				return $this->renderPartial('new-messages', ['messages' => $messages, 'count' => $count]);
			}
		}
		else
		{
			return $this->render('new-messages', ['messages' => $messages, 'count' => $count]);
		}
		
	}
	
	public function actionConversation($c_id)
	{
		$conversation = Conversation::findOne($c_id);
		if ($conversation)
		{
			$message = Yii::$app->runAction('/swap/message/message/create', ['item_id' => $conversation->item_id, 'c_id' => $conversation->id]);
			return $this->render('conversation', ['conversation' => $conversation, 'message' => $message]);
		}
	}
}