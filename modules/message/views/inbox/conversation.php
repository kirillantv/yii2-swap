<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
use yii\helpers\Html;
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h4>
			<small>
				<?= Html::encode('@'.$info->interlocutor.': ') ?>	
			</small>
			<?= Html::encode($info->item->title) ?>
		</h4>
	</div>
	<div class="panel-body">
		<?php foreach($dialog as $msg): ?>
			<div class="col-md-12" style="margin-bottom:10px">
				<div class="row">
					<div class="col-md-6 col-md-<?= $msg->from == Yii::$app->user->identity->id ? 'offset-' : ''?>6">
						<div class="media bg-warning">
						<?= $msg->message; ?>
						</div>
					</div>						
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="panel-footer">
		<?= $this->render('_message', ['message' => $message, 'info' => $info]); ?>
	</div>
</div>