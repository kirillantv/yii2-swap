<?php 
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\controllers\management;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kirillantv\swap\models\management\BasicConfiguration;

class BasicConfigurationController extends Controller {
	
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionIndex() 
    {
    	$model = new BasicConfiguration();
    	
    	$post = Yii::$app->request->post();
        if ($model->load($post) && $model->updateConfigs())
        {
        	return $this->redirect(['index']);
        } else {
        	return $this->render('index', [
        		'model' => $model
        		]);
        }
    }
}