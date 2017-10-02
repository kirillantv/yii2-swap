<?php 
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */

namespace kirillantv\swap\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use kirillantv\swap\filters\OrderAccessControl;
use kirillantv\swap\models\Item;
use kirillantv\swap\models\Order;
use kirillantv\swap\modules\message\models\Message;

class OrdersController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => OrderAccessControl::classname(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['create', 'approve'],
						'roles' => ['@']
						]
					]
				]
			];
	}
	
	public function actionCreate($id)
	{
		$item = Item::findOne($id);
		$order = new Order([
			'scenario' => Order::SCENARIO_CREATE,
			'catcher_id' => Yii::$app->user->identity->id,
			'item_id' => $item->id]);
		$message = new Message();
		$message->compose($item);
		if ($order->load(Yii::$app->request->post()) && $message->load(Yii::$app->request->post())) 
		{	
			$isValid = $order->validate();
			$isValid = $message->validate() && $isValid;
			
			if ($isValid)
			{
				$order->save();
				$message->save();
				Yii::$app->session->setFlash(
                'success',
                'Item was successfully swapped'
        		);
                return $this->redirect(['items/index']);
			}
		}
		else {
			if (Yii::$app->request->isAjax)
			{
				return $this->renderPartial('create', [
	                'order' => $order,
	                'item' => $item,
	                'message' => $message
        		]);
			}
			else
			{
				return $this->render('create', [
	                'order' => $order,
	                'item' => $item,
	                'message' => $message
        		]);
			}
            
		} 
	}
	
	public function actionApprove($order, $backUrl = null)
	{
		if ($backUrl == null)
		{
			$backUrl = Url::home();
		}
		$model = Order::findOne($order);
		$model->approve();
		return $this->redirect($backUrl);
		
	}
}