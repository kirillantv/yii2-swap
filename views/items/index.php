<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;



?>

<div class="col-xs-12">
	<div class="container">
		<div class="col-md-2">
			<div class="row">
				<div class="col-xs-12">
					<?= $this->render('_category', ['categories' => $categories]); ?>
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-xs-12" style="margin-bottom: 10px">
					<div class="row">
						<div class="col-sm-10 col-xs-12">
							<?= $this->render('/_filter', ['filter' => $filter, 'id' => $id]); ?>
						</div>
						<div class="col-sm-2 col-xs-12">
							<?= Html::a('Add Item', ['items/create'], ['class' => 'btn btn-primary']) ?>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="row">
						<?php foreach ($items as $item):?>
					    <div class="col-sm-3">
					    	<?= $this->render('_item', ['item' => $item]); ?>
					    </div>
					    <?php endforeach; ?>
					</div>
				</div>								
			</div>
		</div>		
	</div>
</div>
