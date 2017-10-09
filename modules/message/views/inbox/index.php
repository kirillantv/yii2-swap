<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
/* @var $this yii\web\View */
/* @var $conversations array of kirillantv\swap\modules\message\models\Conversation */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php if ($conversations): ?>
	<?php foreach ($conversations as $conversation): ?>
		<div class="media" style="margin-top: 0px; border: 1px solid #ccc">
		  <a class="pull-left" href="<?= Url::to(['/swap/message/inbox/conversation',
		  												'c_id' => $conversation->id]); ?>">
		  	<!-- I don't know what's wrong with src attribute, but this work -->
		    <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 64px; height: 64px;" 
		    			src="data:image/png;
		    			base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACqUlEQVR4Xu2Y60tiURTFl48STFJMwkQjUTDtixq+Av93P6iBJFTgg1JL8QWBGT4QfDX7gDIyNE3nEBO6D0Rh9+5z9rprr19dTa/
		    			XW2KHl4YFYAfwCHAG7HAGgkOQKcAUYAowBZgCO6wAY5AxyBhkDDIGdxgC/M8QY5AxyBhkDDIGGYM7rIAyBgeDAYrFIkajEYxGIwKBAA4PDzckpd+322243W54PJ5P5f6Omh9tqiTAfD5HNpuFVqvFyckJms0m9vf3EY/
		    			H1/u9vb0hn89jsVj8kwDfUfNviisJ8PLygru7O4TDYVgsFtDh9Xo9NBrNes9cLgeTybThgKenJ1SrVXGf1WoVDup2u4jFYhiPx1I1P7XVBxcoCVCr1UBfTqcTrVYLe3t7OD8/x/HxsdiOPqNGo9Eo0un02gHkBhJmuVzC7/
		    			fj5uYGXq8XZ2dnop5Mzf8iwMPDAxqNBmw2GxwOBx4fHzGdTpFMJkVzNB7UGAmSSqU2RoDmnETQ6XQiOyKRiHCOSk0ZEZQcUKlU8Pz8LA5vNptRr9eFCJQBFHq/
		    			/szG5eWlGA1ywOnpqQhBapoWPfl+vw+fzweXyyU+U635VRGUBOh0OigUCggGg8IFK/teXV3h/v4ew+Hwj/OQU4gUq
		    			/w4ODgQrkkkEmKEVGp+tXm6XkkAOngmk4HBYBAjQA6gEKRmyOL05GnR99vbW9jtdjEGdP319bUIR8oA+pnG5OLiQoghU5OElFlKAtCGr6+vKJfLmEwm64aosd/
		    			XbDbbyIBSqSSeNKU+HXzlnFAohKOjI6maMs0rO0B20590n7IDflIzMmdhAfiNEL8R4jdC
		    			/EZIJj235R6mAFOAKcAUYApsS6LL9MEUYAowBZgCTAGZ9NyWe5gCTAGmAFOAKbAtiS7TB1Ng1ynwDkxRe58vH3FfAAAAAElFTkSuQmCC">
		  </a>
		  <div class="media-body">
		  	<div class="col-xs-10">
		  		<div class="row">
		  			<h4 class="media-heading"><?= Html::encode($conversation->item->title) ?></h4>
				    <div class="col-xs-12">
				    	<span>
				    		<?= Html::encode('with @'.$conversation->interlocutor->username) ?>
				    	</span>
				    </div>
				    <div class="col-xs-12">
				    	<div class="row">
				    		<?= Html::encode($conversation->lastMessage->message)  ?>
				    	</div>
				    </div>
		  		</div>
		  	</div>
		    <div class="col-xs-2">
		    	<div class="row">
		    		<div class="col-xs-12">
		    			<div class="row">
		    				<?= Html::encode('Total: '.$conversation->totalCount)?>
		    			</div>
		    		</div>
		    		<div class="col-xs-12">
		    			<div class="row">
		    				<?= Html::encode('Not read: '.$conversation->notReadCount); ?>
		    			</div>
		    		</div>
		    	</div>
		    </div>
		  </div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="jumbotron">
	  <h1><?= Html::encode('You have no conversations yet'); ?></h1>
	  <p><?= Html::encode('To start your first conversation swap something or ask your questions'); ?></p>
	  <p><a class="btn btn-primary btn-lg" href="<?= Url::to(['/swap/items/index']); ?>"><?= Html::encode('To items page'); ?></a></p>
	</div>
<?php endif; ?>