<?php
/* @var $this yii\web\View */
/* @var $items array kirillantv\swap\models\Item */
?>
				
				
<?php foreach ($items as $item):?>
<div class="col-sm-4">
	<div class="row">
    	<?= $this->render('_item', ['item' => $item]); ?>			    		
	</div>
</div>
<?php endforeach; ?>