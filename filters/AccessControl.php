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

class AccessControl extends \yii\filters\AccessControl
{
	public function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
		        return false;
		}
		
		$actionName = $action->id;
		$beforeAction = 'before'.$actionName;
		
		if ($this->hasMethod($beforeAction))
		{
			return $this->$beforeAction();
		}
		
		return true;
	}
}