<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = 'Update Item: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
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
			<div class="item-update">

			    <h1><?= Html::encode($this->title) ?></h1>
			
			    <?= $this->render('_form', [
			        'model' => $model,
			        'values' => $values
			    ]) ?>
			
			</div>
		</div>
	</div>
</div>


