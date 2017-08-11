<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kirillantv\swap\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
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
			<div class="order-index">
	
			    <h1><?= Html::encode($this->title) ?></h1>
			    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
			
			    <p>
			        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
			    </p>
			    <?= GridView::widget([
			        'dataProvider' => $dataProvider,
			        'filterModel' => $searchModel,
			        'columns' => [
			            ['class' => 'yii\grid\SerialColumn'],
			
			            'id',
			            'item_id',
			            [
			            	'attribute' => 'catcher_id',
			            	'value' => 'catcher.username',
			            	'label' => 'Catcher'
			            	],
			            [
			            	'label' => 'Bets',
			            	'value' => function (Order $order) {
			            		return implode(', ', ArrayHelper::map($order->bets, 'id', 'name'));
			            	}
			            	],
			            'status',
			
			            ['class' => 'yii\grid\ActionColumn'],
			        ],
			    ]); ?>
			</div>
		</div>
	</div>
</div>

