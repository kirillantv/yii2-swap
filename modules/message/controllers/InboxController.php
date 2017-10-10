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
	
	public function actionIndex()
	{
		$conversations = Conversation::find()->with('messages', 'interlocutor')->where(['user_one' => Yii::$app->user->id])
		                ->orWhere(['user_two' => Yii::$app->user->id])
		                ->all();
		return $this->render('index', ['conversations' => $conversations]);
	}
	
	public function actionNewMessages($format = 'json')
	{
		$conversations = Conversation::find()->with([
		'messages' => function($query){
			return $query->select(['id', 'message', 'user_id', 'created_at', 'status', 'conversation_id'])->andWhere(['<>', 'user_id', Yii::$app->user->id]);
		}, 
		'interlocutor' => function($query) {
			return $query->select(['id', 'username']);
		}
		])
		        ->where(['user_one' => Yii::$app->user->id])
		        ->orWhere(['user_two' => Yii::$app->user->id])
		        ->andWhere(['in', 'id', 
		                    (new Query())
		                    ->select('conversation_id')
		                    ->from('swap_message')
		                    ->where(['status' => Message::STATUS_NEW])
		                    ->andWhere(['<>', 'user_id', Yii::$app->user->id])]);
		if ($format == 'json')
		{
			$conversations = $conversations->asArray()->all();
			return Json::encode($conversations);
		}
		else
		{
			
		}
	}
	
	public function actionConversation($c_id)
	{
		$conversation = Conversation::find()->where(['id' => $c_id])->with('interlocutor')->one();
		$viewParams = ['conversation' => $conversation];
		if ($conversation)
		{
			if (Yii::$app->request->isAjax)
			{
				return $this->renderPartial('conversation', $viewParams);
			}
			else
			{
				$message = Yii::$app->runAction('/swap/message/message/create', ['item_id' => $conversation->item_id, 'c_id' => $conversation->id]);
				return $this->render('conversation', ['conversation' => $conversation, 'message' => $message]);
			}
		}
	}
}