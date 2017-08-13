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
use yii\base\Model;
use kirillantv\swap\models\Item;
use kirillantv\swap\models\Category;
use kirillantv\swap\models\Attribute;
use kirillantv\swap\models\Value;
use kirillantv\swap\helpers\Title;

class ItemsController extends Controller
{
	public function actionIndex() 
	{
		$model = Item::find()->with(['categories', 'itemAttributes', 'values', 'bets'])->active();

        $items = $model->orderBy(['created_at' => SORT_DESC])
            ->all();
            
       	$categories = Category::find()->all();
		
		if ($items) {
			return $this->render('index', [
            'items' => $items,
            'categories' => $categories
        ]);
		}
		else {
			return $this->render('error');
		}
        
	}
	
    public function actionCategory($id)
    {
    	$category = $this->findCategoryModel($id);
    	$model = Item::find()->joinWith(['categories', 'values', 'bets'])->active()
    	->forCategory($category->id);
    	$items = $model->orderBy(['created_at' => SORT_DESC])->all();
    	$categories = Category::find()->all();
    	return $this->render('index', [
    		'items' => $items,
            'categories' => $categories,
    		]);
    }
    
    public function actionCreate()
    {
    	if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/security/login']);
        } else {
        	$model = new Item();
			$values = $this->initValues($model);
			$post = Yii::$app->request->post();
	        if ($model->load($post) && $model->save() && Model::loadMultiple($values, $post)) {
	            $this->processValues($values, $model);
	            /**
	             * ОСТОРОЖНО!!!
	             * КОСТЫЛЬ!
	             * 
	             */
	            if ($model->hasCustomTitle())
	            {
	            	$model->title = Title::generateCustomTitle($model);
	            	$model->save();
	            }
				Yii::$app->session->setFlash(
	                'success',
	                'Item was successfully created'
        		);
	            return $this->redirect(['swap/item/view', 'id' => $model->id]);
	        } else {
	            return $this->render('create', [
	                'model' => $model,
	                'values' => $values
	            ]);
	        }
        }
    }
    
    private function initValues(Item $model) 
    {
    	/** @var Value[] $value */
        $values = $model->getValues()
        ->with('itemAttribute')
        ->indexBy('attribute_id')
        ->all();
        
        $attributes = Attribute::find()->indexBy('id')->all();
        
        foreach (array_diff_key($attributes, $values) as $attribute) {
        	$values[$attribute->id] = new Value(['attribute_id' => $attribute->id]);
        }
        
        foreach ($values as $value) {
        	$value->setScenario(Value::SCENARIO_TABULAR);
        }
        
        return $values;
    }
    
    private function processValues($values, Item $model)
    {
    	foreach ($values as $value) {
        		$value->item_id = $model->id;
        		if ($value->validate()) {
        			if (!empty($value->value_string)){
        				$value->save();
        			} else {
        				$value->delete();
        			}
        		}
        	}
    }
    
    protected function findCategoryModel($id)
    {
    	if (($model = Category::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
}
?>