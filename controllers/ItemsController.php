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
use kirillantv\swap\filters\ItemAccessControl;
use kirillantv\swap\models\Item;
use kirillantv\swap\models\Bet;
use kirillantv\swap\models\Category;
use kirillantv\swap\models\Attribute;
use kirillantv\swap\models\Value;
use kirillantv\swap\models\search\ItemSearch;
use kirillantv\swap\helpers\Title;
use kirillantv\swap\models\Order;
use kirillantv\swap\modules\message\models\Message;
use kirillantv\swap\models\forms\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\db\Query;

class ItemsController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => ItemAccessControl::classname(),
				'rules' => [
					[
					'allow' => true,
					'actions' => ['create', 'edit', 'delete', 'to-archive', 'to-active', 'attribute-values'],
					'roles' => ['@']
						],
					[
					'allow' => true,
					'actions' => ['index', 'view', 'category', 'bet'],
					'roles' => ['?', '@']
						]
					],
				]
			];
	}
	
	public function actionIndex() 
	{
		$model = Item::find()->with(['categories', 'values', 'bets', 'images'])->joinWith(['itemAttributes'], false)->active();
		$filter = new ItemSearch();
		if ($filter->loadSearchParams(Yii::$app->request->get()))
		{
			$model = $filter->search($model);	
		}
        $items = $model->orderBy(['created_at' => SORT_DESC])
            ->all();
            
       	$categories = Category::find()->indexBy('id')->all();
		
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
	
    public function actionCategory($id = 0)
    {
    	if (Yii::$app->request->isAjax)
    	{
	    	$category = $this->findCategoryModel($id);
	    	$model = Item::find()->joinWith(['categories', 'values', 'bets'])->active()
	    	->forCategory($category->id)->orderBy(['update_at' => SORT_DESC])->all();
	    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	    	return $this->renderAjax('items', ['items' => $model]);
    	}
    	else
    	{
	    	$category = $this->findCategoryModel($id);
	    	$model = Item::find()->joinWith(['categories', 'values', 'bets'])->active()
	    	->forCategory($category->id);
	    	$filter = new ItemSearch();
			if ($filter->loadSearchParams(Yii::$app->request->get()))
			{
				$model = $filter->search($model);	
			}
	    	$items = $model->orderBy(['update_at' => SORT_DESC])->all();
	    	$categories = Category::find()->indexBy('id')->all();
	    	return $this->render('index', 
	    	    [
	    	    'items' => $items,
	            'categories' => $categories,
	            'id' => $category->id,
	            'filter' => $filter
	    		]);    		
    	}

    }
    
    public function actionBet($id)
    {
    	$bet = $this->findBetModel($id);
    	$model = Item::find()->joinWith(['categories', 'values', 'bets'])->active()
    	->forBet($bet->id);
    	$filter = new ItemSearch();
		if ($filter->loadSearchParams(Yii::$app->request->get()))
		{
			$model = $filter->search($model);	
		}
    	$items = $model->orderBy(['update_at' => SORT_DESC])->all();
    	$categories = Category::find()->all();
    	return $this->render('index', 
    	    [
    		'items' => $items,
            'categories' => $categories,
            'id' => $category->id,
            'filter' => $filter
    		]);
    }
    public function actionCreate()
    {
    	$model = new Item();
    	$uploadForm = new UploadForm();
		$values = $this->initValues($model);
		$post = Yii::$app->request->post();
        if ($model->load($post) && Model::loadMultiple($values, $post) && $model->validate() && Model::validateMultiple($values, ['value_string'])) {
            $model->save();
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
            $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');
            $uploadForm->item_id = $model->id;
            $uploadForm->upload();
			Yii::$app->session->setFlash(
                'success',
                'Item was successfully created'
    		);
            return $this->redirect(['items/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'values' => $values,
                'uploadForm' => $uploadForm
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
    
    public function actionEdit($id)
    {
    	$model = Item::findOne($id);
    	$uploadForm = new UploadForm(['item_id' => $model->id]);
    	$uploadForm->scenario = UploadForm::SCENARIO_UPDATE;
		$values = $this->initValues($model);
		$post = Yii::$app->request->post();
        if ($model->load($post) && Model::loadMultiple($values, $post) && $model->validate() && Model::validateMultiple($values, ['value_string'])) {
            $model->save();
            $this->processValues($values, $model);
            /**
             * ОСТОРОЖНО!!!
             * КОСТЫЛЬ!
             * 
             */
            $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');

            $uploadForm->upload();
            if ($model->hasCustomTitle())
            {
            	$model->scenario = Item::SCENARIO_CHANGE_TITLE;
            	$model->title = Title::generateCustomTitle($model);
            	$model->save();
            }
			Yii::$app->session->setFlash(
                'success',
                'Item was successfully updated'
    		);
            return $this->redirect(['items/view', 'id' => $id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'values' => $values,
                'uploadForm' => $uploadForm
            ]);
        }
    }
    
    public function actionDelete($id)
    {
    	$result = $this->findModel($id)->delete();
    	if ($result)
    	{
			Yii::$app->session->setFlash(
                'success',
                'Item was successfully deleted'
    		);  
    		return $this->redirect(Url::previous());
    	}
        if ($result == false)
        {
			Yii::$app->session->setFlash(
                'success',
                'Item can\'t be deleted'
    		);  
    		return $this->redirect(Url::previous());        	
        }
    }
    
    public function actionToArchive($id)
    {
    	$item = $this->findModel($id);
    	$item->scenario = Item::SCENARIO_CHANGE_STATUS;
    	$result = $item->toArchive();
    	return $this->redirect(['items/view', 'id' => $id]);
    }

    public function actionToActive($id)
    {
    	$item = $this->findModel($id);
    	$item->scenario = Item::SCENARIO_CHANGE_STATUS;
    	$item->toActive();
    	return $this->redirect(['items/view', 'id' => $id]);
    }
    
    public function actionAttributeValues($attributeId, $q)
    {
    	$query = new Query();
    	$query->select('value_string')
    	->from('{{%value}}')
    	->where(['attribute_id' => $attributeId])
    	->andWhere(['like', 'value_string', $q])
    	->orderBy('value_string');
    	$command = $query->createCommand();
    	$data = $command->queryAll();
	    $out = [];
	    foreach ($data as $d) {
	        $out[] = ['value' => $d['value_string']];
	    }
	    echo \yii\helpers\Json::encode($out);	
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
    
    protected function findBetModel($id)
    {
    	if (($model = Bet::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    
    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
?>