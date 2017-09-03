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
use yii\filters\AccessControl;
use kirillantv\swap\models\Item;
use kirillantv\swap\models\Category;
use kirillantv\swap\models\Attribute;
use kirillantv\swap\models\Value;
use kirillantv\swap\models\search\ItemSearch;
use kirillantv\swap\helpers\Title;

class ItemsController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::classname(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['create'],
						'roles' => ['@']
						],
					[
					'allow' => true,
					'actions' => ['index', 'view', 'category'],
					'roles' => ['?', '@']
						]
					],
				]
			];
	}
	public function actionIndex() 
	{
		$model = Item::find()->with(['categories', 'values', 'bets'])->joinWith(['itemAttributes'], false)->active();
		$filter = new ItemSearch();
		if ($filter->loadSearchParams(Yii::$app->request->get()))
		{
			$model = $filter->search($model);	
		}
        $items = $model->orderBy(['created_at' => SORT_DESC])
            ->all();
            
       	$categories = Category::find()->all();
		
		if ($items) {
			return $this->render('index', [
            'items' => $items,
            'categories' => $categories,
            'filter' => $filter
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
    	$filter = new ItemSearch();
		if ($filter->loadSearchParams(Yii::$app->request->get()))
		{
			$model = $filter->search($model);	
		}
    	$items = $model->orderBy(['created_at' => SORT_DESC])->all();
    	$categories = Category::find()->all();
    	return $this->render('index', [
    		'items' => $items,
            'categories' => $categories,
            'id' => $category->id,
            'filter' => $filter
    		]);
    }
    
    public function actionCreate()
    {
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
            	$model->scenario = Item::SCENARIO_CHANGE_TITLE;
            	$model->title = Title::generateCustomTitle($model);
            	$model->save();
            }
			Yii::$app->session->setFlash(
                'success',
                'Item was successfully created'
    		);
            return $this->redirect(['items/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'values' => $values
            ]);
        }
    }
    
    public function actionView($id)
    {
    	$item = Item::findOne($id);
    	
    	if ($item)
    	{
    		return $this->render('view', ['item' => $item]);
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