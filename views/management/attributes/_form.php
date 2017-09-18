<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use kirillantv\swap\models\Attribute;

/* @var $this yii\web\View */
/* @var $model kirillantv\swap\models\Attribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type')->dropDownList([
                            Attribute::TYPE_STRING => 'String', 
                            Attribute::TYPE_NUMBER => 'Number',
                            Attribute::TYPE_DROPDOWN => 'Dropdown',
                            Attribute::TYPE_CHECKBOX => 'Checkbox'
                            ]) ?>
    <div id="value-block" style="display: <?= $model->type == Attribute::TYPE_DROPDOWN ? 'block' : 'none'?>">
    	<?= $form->field($model, 'value')->textInput() ?>
    </div>
    <?= $form->field($model, 'required')->dropDownList([0 => 'No', 1 => 'Yes']) ?>
    <?= $form->field($model, 'searchable')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<JS
	$('#attribute-type').on('change', function(e) {
		var type = $('#attribute-type').val();
		if (type == 'dropdown')
		{
			$('#value-block').show();
		}
		else
		{
		    $('#value-block').hide();
		}
		
	}) 
	
	
JS;
$this->registerJs($script);
