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

class ItemAccessControl extends AccessControl
{
	public function beforeEdit()
	{
		$item = Item::findOne(Yii::$app->request->get('id'));
		
		if ($item->author_id == Yii::$app->user->identity->id)
		{
			return true;
		}
		else
		{
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		}
	}
	
	public function beforeDelete()
	{
		$item = Item::findOne(Yii::$app->request->get('id'));
		
		if ($item->author_id == Yii::$app->user->identity->id)
		{
			return true;
		}
		else
		{
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		}		
	}
	
	public function beforeToArchive()
	{
		$item = Item::findOne(Yii::$app->request->get('id'));
		
		if ($item->author_id == Yii::$app->user->identity->id)
		{
			return true;
		}
		else
		{
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		}		
	}
	
	public function beforeToActive()
	{
		$item = Item::findOne(Yii::$app->request->get('id'));
		
		if ($item->author_id == Yii::$app->user->identity->id)
		{
			return true;
		}
		else
		{
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		}		
	}
}