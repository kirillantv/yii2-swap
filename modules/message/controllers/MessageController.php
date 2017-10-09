<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */

namespace kirillantv\swap\modules\message\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use kirillantv\swap\models\Item;
use kirillantv\swap\modules\message\models\Message;
use yii\helpers\Json;
use kirillantv\swap\modules\message\models\Conversation;

class MessageController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::classname(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['create'],
						'roles' => ['@']
						]
					]
				]
			];		
	}
	
	public function actionCreate($item_id, $c_id = null, $template = false)
	{
		$item = Item::findOne($item_id);
		if (!Item::findOne($item_id))
		{
			return $this->redirect('error');
		}		
		$message = new Message();
		
		if ($message->load(Yii::$app->request->post()))
		{
			$conversation = Conversation::getConversation($item_id, $c_id);
			$message->setAttributes(['conversation_id' => $conversation->id]);
			$result = $message->save();
			
			if (Yii::$app->request->isAjax)
			{
				return Json::encode(['result' => $result, 'message' => $message, 'conversation' => $conversation, 'item' => $item]);	
			}
			
			if ($template == false)
			{
				return $this->renderPartial('create', ['message' => $message, 'item' => $item]);
			}
			else
			{
				return $this->render('create', ['message' => $message, 'item' => $item]);
			}
		}
		else
		{
			if (Yii::$app->request->isAjax || $template == false)
			{
				return $this->renderPartial('create', ['message' => $message, 'item' => $item]);
			}
			else
			{
				return $this->render('create', ['message' => $message, 'item' => $item]);
			}
		}
	}
	
	public function actionDelete($id)
	{
		$message = Message::findOne($id);
		if ($message->delete())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}