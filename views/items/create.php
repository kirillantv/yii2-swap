<?php
$this->title = 'Create Item';

/* @var $this yii\web\View */
/* @var $model kirillantv\swap\models\Item */
/* @var $form yii\widgets\ActiveForm */
/* @var $values array kirillantv\swap\models\Value */
?>

<div class="create-form">
    <?= $this->render('_form', ['model' => $model, 'values' => $values, 'uploadForm' => $uploadForm]); ?>
</div>
