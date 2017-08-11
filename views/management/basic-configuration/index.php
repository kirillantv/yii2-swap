<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kirillantv\swap\models\BasicConfig;
use kirillantv\swap\models\Item;


/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Config';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">
	<div class="row">
		<div class="col-md-2">
			<div class="row">
				<?php echo $this->render('@vendor/kirillantv/yii2-swap/views/management/_menu'); ?>
			</div>
		</div>
		<div class="col-md-10">
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
				<div class="col-xs-12">
					<a type="button" class="link" data-toggle="collapse" data-target="#avAttributes">
					  	<?= Html::encode('See availible attributes for title formula'); ?>
					</a>
					<div id="avAttributes" class="collapse">
						<p>
							<?php foreach($model->availibleAttributes as $attribute): ?>
							<span class="badge">
								<?= Html::encode('%'.$attribute.'%'); ?>
							</span>
							<?php endforeach; ?>	
						</p>
						
						<?= Html::tag('br'); ?>
						<p><em><?= Html::encode('For example, your formula can looks like: '); ?></em></p>
						
						<div class="well well-sm">
							<strong><?= Html::encode('%attribute1%') ?></strong>
							<?= Html::encode(' some text ') ?>
							<strong><?= Html::encode('%attribute2% %attribute3%') ?></strong>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>



