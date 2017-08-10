<?php
use yii\helpers\Html;
?>

<div class="list-group">
	<?php foreach ($categories as $category):?>
		<?= Html::a($category->name, ['items/category', 'id' => $category->id], ['class' => 'list-group-item']) ?>
	<?php endforeach; ?>
</div>