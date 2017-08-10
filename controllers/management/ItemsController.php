<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */

namespace kirillantv\swap\controllers\management;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kirillantv\swap\models\BasicConfig;
use kirillantv\swap\models\Item;
use kirillantv\swap\models\Attribute;
use kirillantv\swap\models\Value;
use kirillantv\swap\models\management\search\ItemSearch;
use kirillantv\swap\helpers\Title;

/**
 * ItemsController implements the CRUD actions for Item model.
 */
class ItemsController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();
		$values = $this->initValues($model);
		$post = Yii::$app->request->post();
        if ($model->load($post) && $model->save() && Model::loadMultiple($values, $post)) {
            $this->processValues($values, $model);
            $savedItem = Item::findOne($model->id);
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
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'values' => $values
            ]);
        }
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $values = $this->initValues($model);

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save() && Model::loadMultiple($values, $post)) {
        	$this->processValues($values, $model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'values' => $values
            ]);
        }
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}
