<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $conversation kirillantv\swap\modules\message\services\Conversation */
/* @var $message yii\web\View result of rendering /swap/message/message/create controller */
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>
			<a href="<?= Url::to(['/swap/items/view', 'id' => $conversation->item->id])?>"><?= Html::encode($conversation->item->title) ?></a>
		</h4>
		<p><?= Html::encode('with @'.$conversation->interlocutor->username) ?></p>
	</div>
	<div class="panel-body" style="max-height: 100vh; overflow:auto">
		<?php foreach($conversation->messages as $msg): ?>
			<div class="col-xs-12">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<h5>
								<p class="text-info">
									<?= '@'.$msg->user->username.' ' ?>
									<small class="text-default">
										<?= $msg->created_at ?>
									</small>
								</p>
							</h5>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="row">
							<?= $msg->message; ?>
						</div>
					</div>						
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="panel-footer">
		<?= $message ?>
	</div>
</div>
