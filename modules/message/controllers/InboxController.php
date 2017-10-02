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
use kirillantv\swap\modules\message\models\Message;
use kirillantv\swap\models\Item;
use kirillantv\swap\modules\message\services\Conversation;

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
						'actions' => ['index', 'conversation'],
						'roles' => ['@']
						]
					]
				]
			];		
	}
	
	public function actionIndex()
	{
		$dialogs = Message::find()->inbox()->all();
		return $this->render('index', ['dialogs' => $dialogs]);
	}
	
	public function actionConversation($item_id, $from, $to)
	{
		$conversation = new Conversation(['item_id' => $item_id, 'participants' => [$from, $to]]);
		if (!Yii::$app->request->isAjax)
		{
			$message = new Message(['scenario' => Message::SCENARIO_CONVERSATION]);
			$message->compose(Item::findOne($item_id), $conversation->info->sender->id == Yii::$app->user->identity->id ? $conversation->info->recipient->id : $conversation->info->sender->id);
			
			if ($message->load(Yii::$app->request->post()) && $message->validate())
			{
				$message->save();
				Yii::$app->session->setFlash(
		                'success',
		                'Message to @'.$info->interlocutor.' was successfully sent'
	        		);
	        	return $this->redirect(['conversation', 'item' => $message->item_id, 'from' => $message->from, 'to' => $message->to]);
			}
			else
			{
				return $this->render('conversation', ['message' => $message, 'conversation' => $conversation]);
			}
		}
		else
		{
			return $this->renderPartial('conversation', ['message' => $message, 'conversation' => $conversation]);
		}
	}
	
	public function actionCreate($item_id = null, $to = null)
	{
		$message = new Message(['scenario' => Message::SCENARIO_CONVERSATION]);
		
	}
}