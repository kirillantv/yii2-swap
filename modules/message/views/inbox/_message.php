<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<?= Html::activeTextarea($message, 'message', [
				'class' => 'form-control', 
				'style' => 'margin-bottom:10px', 
				'placeholder' => 'To @'. $info->interlocutor ])?>
<?= Html::submitButton('Send message', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>