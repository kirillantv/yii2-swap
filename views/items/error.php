<?php
use yii\helpers\Html;

$this->title="No items found";
?>
<h2><?= Html::encode('No items found :('); ?></h2>
<h4><?= Html::encode('But you can create your first one!'); ?></h4>

<hr />
<?= Html::a('Create Item', ['items/create'], ['class' => 'btn btn-primary']); ?>