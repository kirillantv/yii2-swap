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
use yii\web\Response;
use yii\db\Query;

class BetsController extends Controller
{
	public function actionBetslist($format = 'json')
	{
		if ($format == 'json')
		{
			
		}
		if (Yii::$app->request->isAjax)
		{
			$query = new Query();
    		$query->select('name')
    		->from('{{%bet}}')
    		
    		->where(['like', 'name', 'о'])
    		->orderBy('name');
    		$command = $query->createCommand();
    		$data = $command->queryAll(); 
	    	$out = [];
		    foreach ($data as $d) {
		        $out[] = ['value' => $d['name']];
		    }
	    	echo \yii\helpers\Json::encode($out);;
		}
	}
}