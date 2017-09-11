<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\filters;

use Yii;
use yii\web\ForbiddenHttpException;
use kirillantv\swap\models\Order;
use kirillantv\swap\models\Item;

class OrderAccessControl extends AccessControl
{
	public function beforeCreate()
	{
		$item = Item::findOne(Yii::$app->request->get('id'));
		if ($item->author_id === Yii::$app->user->identity->id)
		{
			Yii::$app->session->setFlash(
                'danger',
                'You can\'t swap your items'
            );
			Yii::$app->getResponse()->redirect(['/swap/items/index']);
			return false;
		}
		if ($item->active != 1) {
			Yii::$app->session->setFlash(
                'warning',
                'This item has been already swapped'
    		);
    		
    		Yii::$app->getResponse()->redirect(['/swap/items/index']);
			return false;
		}
		
		return true;
	}
	
	public function beforeApprove()
	{
		$order = Order::findOne(Yii::$app->request->get('order'));
		$user = Yii::$app->user->identity->id;
		if ($order->catcher->id == $user || $order->item->author->id == $user)
		{
			return true;
		}
		else 
		{
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		}
	}	
}