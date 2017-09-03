<?
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>
<h4>
    <?= Html::encode('Choose bets:');?>
</h4>
<?php $form = ActiveForm::begin(); ?>
<?= Html::activeCheckboxList($order, 'betsArray', ArrayHelper::map($item->bets, 'id', 'name'), ['class' => 'checkbox', 'separator' => '<br>','itemOptions' => ['label' => 'checkbox']]) ?>
<?= Html::label('Tell to @'.$item->author->username.'little more, for example, about location where you can swap and etc...', 'message-message'); ?>
<?= Html::activeTextarea($activeMessage, 'message', ['class' => 'form-control', 'placeholder' => 'Tell more...'])?>
<div class="form-group" style="margin-top:1%">
	<div class="col-sm-12">
		<?= Html::submitButton('To swap', ['class' => 'btn btn-success btn-block']) ?>
	</div>
 	<div class="col-sm-12">
 		<button type="button" class="btn btn-link btn-block" data-toggle="modal" data-target="#message">
		  <?= Html::encode('Contact with @'.$item->author->username) ?>
		</button>
 	</div>
</div>
<?php ActiveForm::end(); ?>
<!-- Modal window -->
<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="messageLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Send your message to @<?= $item->author->username ?> about this item</h4>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::activeTextarea($passiveMessage, 'message', ['class' => 'form-control', 'placeholder' => 'To @'. $item->author->username.'...' ])?>
        
      </div>
      <div class="modal-footer">
        <?= Html::submitButton('Send message', ['class' => 'btn btn-success btn-block']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>