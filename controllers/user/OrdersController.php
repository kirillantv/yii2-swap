<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\controllers\user;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use kirillantv\swap\models\Order;

class OrdersController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::classname(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['active', 'archive', 'index'],
						'roles' => ['@']
						]
					]
				]
			];
	}
	
	public function actionIndex()
	{
		return $this->redirect(['user/orders/active']);
	}
	
	public function actionActive() 
    {
        $currentUserId = Yii::$app->user->identity->id;
        $model = Order::find()->joinWith(['item'])->forUser($currentUserId)->active();
        return $this->render('orders', ['model' => $model]);
    }
    
    public function actionArchive() 
    {
        $currentUserId = Yii::$app->user->identity->id;
        $model = Order::find()->joinWith(['item'])->forUser($currentUserId)->archive();
        return $this->render('orders', ['model' => $model]);
    }
}