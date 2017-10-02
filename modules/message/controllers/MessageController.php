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
	
	public function actionCreate($item_id = null)
	{
		if ($item_id != null)
		{
			$item = Item::findOne($item_id);
			$message = new Message();
			$message->compose($item);
			
			$viewParams = ['message' => $message, 'item' => $item];
			// For Ajax requests
			if (Yii::$app->request->isAjax)
			{
				if ($message->load(Yii::$app->request->post()) && $message->validate())
				{
					if ($message->save())
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return $this->renderPartial('create', $viewParams);
				}
			}
			
			else
			{
				if ($message->load(Yii::$app->request->post()) && $message->validate())
				{
					if ($message->save())
					{
						return $this->goBack();
					}
				}
				else
				{
					return $this->render('create', $viewParams);
				}
				
			}
		}
	}
	
}