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
use yii\db\Query;
use yii\web\ForbiddenHttpException;
use yii\helpers\Json;
use kirillantv\swap\models\SwapImage;
use yii\web\JsExpression;
use yii\helpers\Url;

class ImagesController extends Controller
{
	public function actionDelete($image_id = null)
	{
		if ($image_id == null)
		{
			$image_id = Yii::$app->request->post('image_id');
		}
		if (Yii::$app->request->isAjax)
		{
			$image = SwapImage::findOne($image_id);
			if ($image->item->author_id == Yii::$app->user->identity->id)
			{
				if (Yii::getAlias('@web') == null)
				{
					$root = Yii::getAlias('@frontend').'/web';
				}
				else
				{
					$root = Yii::getAlias('@web');
				}
				if (unlink($root.$image->path))
				{
					$image->delete();
					return 1;
				}
				else
				{
					return 0;
				}
			}
			else
			{
				return Json::encode('This is not your image');
			}
		}
	}
}