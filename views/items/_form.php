<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\Category;
 ?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-md-6">
		<?= $form->field($uploadForm, 'imageFile')->fileInput() ?>
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