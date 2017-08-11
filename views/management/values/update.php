<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Value */

$this->title = 'Update Value: ' . $model->item_id;
$this->params['breadcrumbs'][] = ['label' => 'Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_id, 'url' => ['view', 'item_id' => $model->item_id, 'attribute_id' => $model->attribute_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-xs-12">
	<div class="row">
		<div class="col-md-2">
			<div class="row">
				<?php echo $this->render('@vendor/kirillantv/yii2-swap/views/management/_menu'); ?>
			</div>
		</div>
		<div class="col-md-10">
			<div class="value-update">

			    <h1><?= Html::encode($this->title) ?></h1>
			
			    <?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
			
			</div>
		</div>
	</div>
</div>

