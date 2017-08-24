<?php
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\Item;

$this->title = "To swap";
?>

<div class="order-form">
	
</div>
<div class="container">
	<div class="col-md-12">
		<div class="panel panel-default">
			 <div class="panel-heading">
			 	<h2><?= $item->title ?></h2>
			 </div>
			 <div class="panel-body">
			 	<div class="col-md-6 col-xs-12">
			 		<div style="background-color: rgb(245, 245, 245); height:350px">
			 			
			 		</div>
			 	</div>
			 	<div class="col-md-6 col-xs-12">
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
					<div class="col-xs-12">
						<div class="col-xs-12">
							<h4>
								<?= Html::encode('Choose bets:');?>
							</h4>
							<?php $form = ActiveForm::begin(); ?>
							<?= Html::activeCheckboxList($order, 'betsArray', ArrayHelper::map($item->bets, 'id', 'name'), ['class' => 'checkbox', 'separator' => '<br>','itemOptions' => ['label' => 'checkbox']]) ?>
							<?= Html::label('Tell to @'.$item->author->username.'little more, for example, about location where you can swap and etc...', 'message-message'); ?>
							<?= Html::activeTextarea($activeMessage, 'message', ['class' => 'form-control', 'placeholder' => 'Tell more...'])?>
							<div class="form-group" style="margin-top:1%">
								<div class="col-sm-12">
									<?= Html::submitButton('To swap', ['class' => 'btn btn-success btn-block']) ?>
								</div>
							 	<div class="col-sm-12">
							 		<button type="button" class="btn btn-link btn-block" data-toggle="modal" data-target="#message">
									  <?= Html::encode('Contact with @'.$item->author->username) ?>
									</button>
							 		<?/*= Html::a('Contact with @'.$item->author->username, ['message/create', 'item' => $item->id], ['class' => 'btn btn-link btn-block']);*/?>
							 	</div>
					    	</div>
							<?php ActiveForm::end(); ?>
							<?= $this->render('message', ['passiveMessage' => $passiveMessage, 'author' => $item->author->username]); ?>
						</div>
					</div>
			 	</div>
			 </div>
		</div>
	</div>
</div>