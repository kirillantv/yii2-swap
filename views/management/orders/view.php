<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
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
			<div class="order-view">
			
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
			            'item_id',
			            'catcher_id',
			            'status',
			        ],
			    ]) ?>
			
			</div>
		</div>
	</div>
</div>

