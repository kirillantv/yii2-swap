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
	
	public function actionConversation($hash, $item, $from, $to)
	{
		$dialog =  Message::find()->conversation($hash, $item, $from, $to)->orderBy(['created_at' => SORT_ASC])->all();
		$info = $dialog[0];
		$message = new Message(['scenario' => Message::SCENARIO_CONVERSATION]);
		$message->compose(Item::findOne($item), $info->sender->id == Yii::$app->user->identity->id ? $info->recipient->id : $info->sender->id);
		
		if ($message->load(Yii::$app->request->post()) && $message->validate())
		{
			$message->save();
			Yii::$app->session->setFlash(
	                'success',
	                'Message to @'.$info->interlocutor.' was successfully sent'
        		);
        	return $this->redirect(['conversation', 'hash' => $message->hash, 'item' => $message->item_id, 'from' => $message->from, 'to' => $message->to]);
		}
		return $this->render('conversation', ['dialog' => $dialog, 'message' => $message, 'info' => $info]);
	}
}