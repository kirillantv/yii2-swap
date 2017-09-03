<?php
use yii\helpers\Html;
?>
<div class="col-xs-12">
 	<span class="pull-right">
 		<h4>
 			from: @<?= $item->author->username ?>
 		</h4>
 	</span>
 </div>
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
<div class="col-xs-12">
	<strong>
		@<?= $item->author->username ?> wants:
	</strong>
	<?php foreach ($item->bets as $bet) {?>
		<span class="btn btn-sm btn-success"><?= Html::encode($bet->name) ?></span>
	<?php } ?>
</div>