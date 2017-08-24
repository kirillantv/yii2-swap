<?php
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\Item;

?>
 
<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="messageLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Send your message to @<?= $author ?> about this item</h4>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::activeTextarea($passiveMessage, 'message', ['class' => 'form-control', 'placeholder' => 'To @'. $author.'...' ])?>
        
      </div>
      <div class="modal-footer">
        <?= Html::submitButton('Send message', ['class' => 'btn btn-success btn-block']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>