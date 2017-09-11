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
        $order = new Order(['scenario' => Order::SCENARIO_CREATE]);
		
		$item = Item::findOne($id);
		
		$order->catcher_id = Yii::$app->user->identity->id;
		$order->item_id = $item->id;
		
		// Active Message and passive message
		// We need to separate it to make different validations for message with order and simple message
		$activeMessage = new Message();
		$activeMessage->compose($item);
		
		$passiveMessage = new Message();
		$passiveMessage->compose($item);
		
		if ($order->load(Yii::$app->request->post()) && $activeMessage->load(Yii::$app->request->post())) 
		{	
			$isValid = $order->validate();
			$isValid = $activeMessage->validate() && $isValid;
			
			if ($isValid)
			{
				$order->save();
				$activeMessage->save();
				Yii::$app->session->setFlash(
                'success',
                'Item was successfully swapped'
        		);
                return $this->redirect(['items/index']);
			}
		}
		if ($passiveMessage->load(Yii::$app->request->post()) && $passiveMessage->validate())
		{
			$passiveMessage->save();
			Yii::$app->session->setFlash(
	                'success',
	                'Message to @'.$item->author->username.' was successfully sent'
        		);
        	return $this->redirect(['orders/create', 'id' => $id]);
		}
		else {
            return $this->render('create', [
                'order' => $order,
                'item' => $item,
                'activeMessage' => $activeMessage,
                'passiveMessage' => $passiveMessage
            ]);
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