<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\Attribute;
?>

<?php/* $form = ActiveForm::begin([
	'method' => 'get',
	'options' => 
		[]
		]); ?>
<?= $form->field($filter, 'search')->hiddenInput(['value' => 'true']); ?>
<?= $form->field($filter, 'for')->dropDownList(Attribute::find()
    														->select(['name', 'id'])
    														->indexBy('id')->column())
    														->label('Choose attribute'); ?>
<?= $form->field($filter, 's')->textInput(); ?>
<?php ActiveForm::end();*/?>
<?= Html::beginForm(['', 'search' => 'true', 'id' => $id], 'get', ['class' => 'form-inline']); ?>
<div class="form-group">
<?= Html::dropDownList('for', $filter->for, Attribute::find()
											->select(['name', 'id'])
											->indexBy('id')->column(),  ['class' => 'form-control btn-primary']) ?>	
</div>
<div class="form-group">
	<?= Html::input('text', 's', $filter->s, ['class' => 'form-control']) ?>	
</div>
<?= Html::submitButton('Search', ['class' => 'btn btn-inverse']) ?>
<?= Html::endForm();
