<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\BasicConfig;
use kirillantv\swap\models\Item;


/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="basic-configuration-form">

    <?php $form = ActiveForm::begin(); ?>
    
<div class="row">
	<div class="col-md-6">
		<?= $form->field($model, 'isCustomTitle')->checkbox()?>
		<?= $form->field($model, 'customTitleFormula')->textInput()?>
	</div>
	<div class="col-md-6">
		
	</div>
	
</div>
<div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>