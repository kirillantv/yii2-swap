<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kirillantv\swap\models\Item;
use kirillantv\swap\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">
	<div class="row">
		<div class="col-md-2">
			<div class="row">
				<?php echo $this->render('@vendor/kirillantv/yii2-swap/views/management/_menu'); ?>
			</div>
		</div>
		<div class="col-md-10">
			<div class="item-index">
			
			    <h1><?= Html::encode($this->title) ?></h1>
			    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
			
			    <p>
			        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
			    </p>
			    <?= GridView::widget([
			        'dataProvider' => $dataProvider,
			        'filterModel' => $searchModel,
			        'columns' => [
			            [
			            	'attribute' =>'id',
			            	'options' => ['style' => 'width:20px']
			            	],
			            [
			            	'attribute' => 'title',
			            	'options' => ['style' => 'width:150px']
			            	],
			            [
			            	'attribute' => 'author_id',
			            	'value' => 'author.username',
			            	'label' => 'Author',
			            	'options' => ['style' => 'width:20px']
			            	],
			            [
			            	'attribute' => 'created_at',
			            	'options' => ['style' => 'width:20px']
			            ],
			            [
			            	'attribute' => 'update_at',
			            	'options' => ['style' => 'width:20px']
			            	],
			            [
			            	'attribute' => 'active',
			            	'filter' => [0 => 'No', 1 => 'Yes'],
			            	'format' => 'boolean',
			            	'options' => ['style' => 'width:20px']
			            ],
			            [
			            	
			            	'label' => 'Categories',
			            	'filter' => Category::find()->select(['name', 'id'])->indexBy('id')->column(),
			            	'value' => function (Item $item) {
			            		return implode(', ', ArrayHelper::map($item->categories, 'id', 'name'));
			            	}
			            	],
			            [
			            	'label' => 'Bets',
			            	'value' => function (Item $item) {
			            		return implode(', ', ArrayHelper::map($item->bets, 'id', 'name'));
			            	}
			            	],
			            [
			            	'label' => 'Order',
			            	'value' => function (Item $item) {
			            		return implode(', ', ArrayHelper::map($item->orders, 'id', 'id'));
			            	}
			            	],
			            ['class' => 'yii\grid\ActionColumn'],
			        ],
			    ]); ?>
			</div>	
		</div>
	</div>
</div>

