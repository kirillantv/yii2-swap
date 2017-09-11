<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
		<a class="btn btn-sm btn-success" href="<?= Url::to(['items/bet','id' => $bet->id]); ?>"><?= Html::encode($bet->name) ?></a>
	<?php } ?>
</div>