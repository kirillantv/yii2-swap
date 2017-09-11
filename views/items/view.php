<?php
use yii\bootstrap\Html;
use yii\bootstrap\ButtonDropdown;
use kirillantv\dynamicvalue\DynamicValue;
use kirillantv\swap\widgets\OrderForm;
use yii\bootstrap\ButtonGroup;

$this->title = $item->title;
$dropdownAuthorOptions = [
	'label' => 'Action',
	'containerOptions' => ['class' => 'btn-block'],
	'options' => ['class' => 'btn btn-primary btn-block'],
    'dropdown' => [
    'items' => [
	    ['label' => 'Edit', 'url' => ['/swap/items/edit', 'id' => $item->id]],
		['label' => 'Delete', 'url' => ['/swap/items/delete', 'id' => $item->id], 'options' => ['class' => 'bg-danger']],
    	['label' => 'To archive', 'url' => ['/swap/items/to-archive', 'id' => $item->id]],
    	        ]]];
$buttonsGuestOptions = [
	'options' => ['class' => 'btn-block'],
	'buttons' =>
		[
		    ['label' => 'Login', 'tagName' => 'a', 'options' => ['href' => '/user/security/login', 'class' => 'btn btn-info btn-block']],
		    ['label' => 'Signup', 'tagName' => 'a',  'options' => ['href' => '/user/registration/register', 'class' => 'btn btn-link btn-block']]
		]
	];
$orderFormOptions = [
	                'activeMessage' => $activeMessage,
					'passiveMessage' => $passiveMessage,
					'item' => $item,
					'order' => $order];

$label = null;
//Render edit buttons for item's author
if (Yii::$app->user->identity->id === $item->author_id)
{
    $label = ButtonDropdown::widget($dropdownAuthorOptions);
}
//Render registration and auth buttons for guest
if (Yii::$app->user->isGuest)
{
	$label = ButtonGroup::widget($buttonsGuestOptions);
}
//Render swap form for auth users and not item's authors
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id != $item->author_id)
{
	$label = OrderForm::widget($orderFormOptions);
}
?>
<div class="container">
	<div class="col-md-12">
		<div class="panel panel-default">
			 <div class="panel-heading">
			 	<h2><?= $item->title ?></h2>
			 </div>
			 <div class="panel-body">
			 	<div class="col-md-6 col-xs-12">
			 		<div style="background-color: rgb(245, 245, 245); height:350px">
			 			
			 		</div>
			 	</div>
			 	<div class="col-md-6 col-xs-12">
			 		<?= $this->render('/_itemView', ['item' => $item]); ?>
					<div class="col-xs-12">
						<div class="col-xs-12">
							<div style="margin-top:15px">
								<?= DynamicValue::widget([
							    'data' => $item,
							    'column' => 'active',
							    'items' => [
							    	[
							    		'value' => 1,
							    	    'label' => $label,
							    	    'options' => [
							    	    	
							    	    	]
							    	    ],
							    	[
							    	   	'value' => 0,
							    	   	'label' => '<div class="alert-warning alert">Item was swapped</div>',
							    	   	'options' => [
							    	   		
							    	   		]
							    	   	]
							    	]
							    ]); ?>
							</div>
							
						</div>
					</div>
			 	</div>
			 </div>
		</div>
	</div>
</div>