<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\Item;

$this->title = "To swap";
?>

<div class="order-form">
	
</div>
<div class="container">
	<div class="col-md-5">
		<h2 style="background-color:rgba(1, 32, 136, 0.25); padding: 1.3333%"><?= Html::encode('mainUser'/*$item->author->username*/); ?></h2>
		<h3><?php echo $item->title ?></h3>
		<table class="table table-condensed">
			<tbody>
				<?php foreach ($item->values as $attribute) {?>
				<tr>
					<td><?= Html::encode($attribute->itemAttribute->name); ?></td>
					<td><?= Html::encode($attribute->value_string) ?> </td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php foreach ($item->bets as $bet) {?>
			<span class="btn btn-success"><?= Html::encode($bet->name) ?></span>
		<?php } ?>
	</div>
	<div class="col-md-2">
		---------->
	</div>
	<div class="col-md-5">
		<h2 style="background-color:rgba(11, 136, 1, 0.25); padding: 1.3333%"><?= Html::encode('userTest'); ?></h2>
		<?php $form = ActiveForm::begin(); ?>
		<?= Html::activeHiddenInput($order, 'item_id') /*$form->field($order, 'item_id')->hiddenInput()->label('');*/ ?>
		<?= Html::activeHiddenInput($order, 'catcher_id') ?>
		<?= $form->field($order, 'betsArray')->checkboxList(ArrayHelper::map($item->bets, 'id', 'name'))->label('Choose bets'); ?>
		 <div class="form-group">
        	<?= Html::submitButton('To swap', ['class' => 'btn btn-success']) ?>
    	</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>