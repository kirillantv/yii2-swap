<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Attribute;
?>

<div class="item-search">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'fieldConfig' => [
			'options' =>[
				'tag' => 'div',
				'class' => 'form-group'
				]
			]
		]); 
	?>
	<?= Html::beginTag('div', ['class' => 'col-sm-3']) ?>
	<?= Html::activeInput('text', $searchModel, 'searchValue', ['class' => 'form-control', 'placeholder' => 'Search...']); ?>
	<?= Html::endTag('div') ?>
	<?= Html::beginTag('div', ['class' => 'col-sm-2']) ?>
	<?= Html::activeDropDownList($searchModel, 'searchItemAttribute', 
															Attribute::find()
    														->select(['name', 'id'])
    														->indexBy('id')->column(), 
    														['class' => 'form-control', 'placeholder' => 'Search...']) ?>
	<?= Html::endTag('div') ?>
	<div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
	<?php ActiveForm::end(); ?>
</div>