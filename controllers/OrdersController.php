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
use kirillantv\swap\models\Item;
use kirillantv\swap\models\Order;

class OrdersController extends Controller
{
	public function actionCreate()
	{
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/security/login']);
        }
        else {
            $order = new Order(['scenario' => Order::SCENARIO_CREATE]);
			if (Yii::$app->request->get('id'))
			{
	            $item_id = Yii::$app->request->get('id');
			}
			
			$item = Item::findOne($item_id);
			if ($item->author_id === Yii::$app->user->identity->id)
			{
				Yii::$app->session->setFlash(
		                'danger',
		                'You can\'t swap your items'
	            );
				return $this->redirect(['items/index']);
			} else {
				if ($item->active != 1) {
						Yii::$app->session->setFlash(
			                'warning',
			                'This item has been already swapped'
	            		);
					return $this->redirect(['items/index']); 
				}
				else {
					$order->catcher_id = Yii::$app->user->identity->id;
					$order->item_id = $item->id;
					$post = Yii::$app->request->post();
					
					if ($order->load(Yii::$app->request->post()) && $order->save()) {
								Yii::$app->session->setFlash(
					                'success',
					                'Item was successfully swapped'
			            		);
			                    return $this->redirect(['swap/items/index']);
					} 
					else {
			                    return $this->render('create', [
			                        'order' => $order,
			                        'item' => $item
			                    ]);
					} 
				}
			}
			
        }
		
		
		
		
	}
}