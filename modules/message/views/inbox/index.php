<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php foreach ($dialogs as $message): ?>
	<div class="media bg-warning">
	  <a class="pull-left" href="<?= Url::toRoute(['conversation', 
	  												'hash' => $message->hash, 
	  												'item' => $message->item_id, 
	  												'from' => $message->from, 
	  												'to' => $message->to]); ?>">
	    <img class="media-object" src="https://cdn.jsdelivr.net/emojione/assets/png/1f609.png?v=2.2.5" alt="...">
	  </a>
	  <div class="media-body">
	    <h4 class="media-heading"><?= Html::encode($message->item->title) ?></h4>
	    <div class="col-xs-12">
	    	<span>
	    		<?= Html::encode('with @'.$message->interlocutor) ?>
	    	</span>
	    </div>
	    <?= Html::encode($message->message)  ?>
	  </div>
	</div>
<?php endforeach; ?>