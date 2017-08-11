<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Attribute */

$this->title = 'Create Attribute';
$this->params['breadcrumbs'][] = ['label' => 'Attributes', 'url' => ['index']];
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
			<div class="attribute-create">
			    <h1><?= Html::encode($this->title) ?></h1>
			    <?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
			</div>
		</div>
	</div>
</div>

