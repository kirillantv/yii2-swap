<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bets';
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
			<div class="bet-index">
			    <h1><?= Html::encode($this->title) ?></h1>
			    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
			
			    <p>
			        <?= Html::a('Create Bet', ['create'], ['class' => 'btn btn-success']) ?>
			    </p>
			    <?= GridView::widget([
			        'dataProvider' => $dataProvider,
			        'filterModel' => $searchModel,
			        'columns' => [
			            ['class' => 'yii\grid\SerialColumn'],
			
			            'id',
			            'name',
			
			            ['class' => 'yii\grid\ActionColumn'],
			        ],
			    ]); ?>
			</div>
		</div>
	</div>
</div>
