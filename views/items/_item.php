<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


?>
<div class="panel panel-default">
        <div class="panel-heading"><strong><a href="<?= Url::to(['items/view', 'id' => $item->id]); ?>"><?= Html::encode($item->title)?></a></strong></div>
        <div class="panel-body">
        	<img src="<?= $item->images[0]->path ?>" class="img-responsive" style="width:100%" alt="Image">
        	
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
        						<a class="label label-success" href="<?= Url::to(['items/bet', 'id' => $bet->id]); ?>"><?= Html::encode($bet->name) ?></a>
        						<?php } ?>
        					</td>
        			</tr>
        		</tbody>
        	</table>
        	</div>
        	
        <div class="panel-footer">
        	<?= Html::a('To swap <span class="glyphicon glyphicon-transfer"></span>', ['orders/create', 'id' => $item->id], ['class' => 'btn btn-default btn-block']) ?>
        </div>
      </div>