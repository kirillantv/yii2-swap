<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\Attribute;
/* @var $this yii\web\View */
/* @var $filter kirillantv\swap\models\search\ItemSearch */
/* @var $id integer */
?>


<?= Html::beginForm(['', 'search' => 'true', 'id' => $id], 'get', ['class' => 'form-inline']); ?>
<div class="form-group">
<?= Html::dropDownList('for', $filter->for, Attribute::find()->searchable()
											->select(['name', 'id'])
											->indexBy('id')->column(),  ['class' => 'form-control btn-primary']) ?>	
</div>
<div class="form-group">
	<?= Html::input('text', 's', $filter->s, ['class' => 'form-control']) ?>	
</div>
<?= Html::submitButton('Search', ['class' => 'btn btn-default']) ?>
<?= Html::endForm();
