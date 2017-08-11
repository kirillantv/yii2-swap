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
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kirillantv\swap\models\Value;
use kirillantv\swap\models\management\search\ValueSearch;

class ManagementController extends Controller
{
	public function actionIndex()
	{
		return $this->redirect(['management/basic-configuration/index']);
	}
}