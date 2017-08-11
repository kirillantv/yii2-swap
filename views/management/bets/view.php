<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Bet */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bets', 'url' => ['index']];
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
			<div class="bet-view">

			    <h1><?= Html::encode($this->title) ?></h1>
			
			    <p>
			        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
			        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
			            'class' => 'btn btn-danger',
			            'data' => [
			                'confirm' => 'Are you sure you want to delete this item?',
			                'method' => 'post',
			            ],
			        ]) ?>
			    </p>
			
			    <?= DetailView::widget([
			        'model' => $model,
			        'attributes' => [
			            'id',
			            'name',
			        ],
			    ]) ?>
			
			</div>

		</div>
	</div>
</div>

