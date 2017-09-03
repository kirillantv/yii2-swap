<?php
use yii\bootstrap\Html;
use kirillantv\swap\widgets\OrderForm;

$this->title = "To swap";
?>
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
			 		<?= $this->render('/_itemView', ['item' => $item]); ?>
					<div class="col-xs-12">
						<div class="col-xs-12">
							<?= OrderForm::widget(['activeMessage' => $activeMessage,
													'passiveMessage' => $passiveMessage,
													'item' => $item,
													'order' => $order]) ?>
						</div>
					</div>
			 	</div>
			 </div>
		</div>
	</div>
</div>