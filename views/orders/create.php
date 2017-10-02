<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $item kirillantv\swap\models\Item */
/* @var $message kirillantv\swap\modules\Message\models\Message */
/* @var $order kirillantv\swap\models\Order */
?>
<h4>
    <?= Html::encode('Choose bets:');?>
</h4>
<?php $form = ActiveForm::begin(); ?>
<?= Html::activeCheckboxList($order, 'betsArray', ArrayHelper::map($item->bets, 'id', 'name'), ['class' => 'checkbox', 'separator' => '<br>','itemOptions' => ['label' => 'checkbox']]) ?>
<?= Html::label('Tell to @'.$item->author->username.'little more, for example, about location where you can swap and etc...', 'message-message'); ?>
<?= Html::activeTextarea($message, 'message', ['class' => 'form-control', 'placeholder' => 'Tell more...'])?>
<br />
<?= Html::submitButton('To swap', ['class' => 'btn btn-success btn-block']) ?>
<?php ActiveForm::end(); ?>