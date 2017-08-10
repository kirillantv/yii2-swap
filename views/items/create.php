<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\Category;

$this->title = 'Create Item';

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>
    
<div class="row">
	<div class="col-md-6">
		<?php foreach ($values as $value): ?>
		<?= $form->field($value, '[' . $value->itemAttribute->id . ']value_string')->label($value->itemAttribute->name) ?>
		<?php endforeach; ?>
	</div>
	<div class="col-md-6">
		<?php if (!$model->hasCustomTitle()) {?>
		<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
		<?php } ?>
    	<?= $form->field($model, 'categoriesArray')->checkboxList(Category::find()
    														->select(['name', 'id'])
    														->indexBy('id')->column())
    														->label('Choose category') ?>
	<?= $form->field($model, 'betsString')->textInput() ?>
	</div>
</div>

    
	
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
