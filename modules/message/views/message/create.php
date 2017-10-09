<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $item kirillantv\swap\models\Item */
/* @var $message kirillantv\swap\modules\Message\models\Message */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($message, 'message')->textArea(['placeholder' => 'Message...']); ?>
<?= Html::submitButton('Send', ['class' => 'btn btn-success btn-block']) ?>
<?php ActiveForm::end(); ?>