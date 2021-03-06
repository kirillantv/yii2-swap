<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Value */

$this->title = $model->item_id;
$this->params['breadcrumbs'][] = ['label' => 'Values', 'url' => ['index']];
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
			<div class="value-view">
			
			    <h1><?= Html::encode($this->title) ?></h1>
			
			    <p>
			        <?= Html::a('Update', ['update', 'item_id' => $model->item_id, 'attribute_id' => $model->attribute_id], ['class' => 'btn btn-primary']) ?>
			        <?= Html::a('Delete', ['delete', 'item_id' => $model->item_id, 'attribute_id' => $model->attribute_id], [
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
			            'item_id',
			            'attribute_id',
			            'value_string',
			            'value_number',
			        ],
			    ]) ?>
			
			</div>
		</div>
	</div>
</div>

