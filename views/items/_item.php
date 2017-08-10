<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;



?>
<div class="panel panel-default">
        <div class="panel-heading"><strong><?= Html::encode($item->title)?></strong></div>
        <div class="panel-body">
        	
        		<img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
        	
        	<table class="table table-condensed">
        		<tbody>
        			<?php foreach ($item->values as $attribute) {?>
        				<tr>
        					<td><?= Html::encode($attribute->itemAttribute->name) ?></td>
        					<td><?= Html::encode($attribute->value_string) ?></td>
        				</tr>
        			<?php }?>
        			<tr>
        					<td colspan="2">
        						<?php foreach ($item->bets as $bet) {?>
        						<span class="label label-success"><?= Html::encode($bet->name) ?></span>
        						<?php } ?>
        					</td>
        			</tr>
        		</tbody>
        	</table>
        	<?/*= Html::encode($item->item_author) */?>
        	</div>
        	
        <div class="panel-footer">
        	<?= Html::a('To swap <span class="glyphicon glyphicon-transfer"></span>', ['orders/create', 'id' => $item->id], ['class' => 'btn btn-default btn-block']) ?>
        </div>
      </div>