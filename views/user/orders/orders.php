<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\Menu;
use yii\helpers\Url;
use kirillantv\dynamicvalue\DynamicValue;
use kirillantv\swap\models\Order;

$this->title = 'My orders';

$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => $model,
    'pagination' => [
        'pageSize' => 20,
    ],
]);
$items = [
		['label' => 'Active', 'url' => ['user/orders/active']],
		['label' => 'Archive', 'url' => ['user/orders/archive']],
	];
?>
<div class="row">
    <div class="col-xs-12">
    	<?= 
    		Menu::widget([
				'options' => [
					'class' => 'nav nav-tabs nav-justified'
					],
				'items' => $items
			]);
		?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
            	<?php if ($model == null): ?>
                <?= Html::encode('You have no created items. Let\'s create your first one!')?>
                <?php else: ?>
                <?php 
                echo GridView::widget([
				    'dataProvider' => $dataProvider,
                    'columns'   => [
                        [
                        	'label' => 'Order ID',
                        	'attribute' => 'id'
                        	],
                        [
                            'label' => 'Item Title',
                            'attribute' => 'item_id',
                            'format' => 'raw',
                            'value' => function($value) {
                            	return '<a href="'.Url::to(['items/view', 'id' => $value->item->id]).'" target="blank">'.$value->item->title.'</a>';
                            	}
                        ],
                        [
                            'label' => 'Giver',
                            'attribute' => 'item_id',
                            'value' => 'item.author.username'
                        ],
                        [
                            'label' => 'Catcher',
                            'attribute' => 'catcher_id',
                            'value' => 'catcher.username'
                        ],
                        [
                        	'label' => 'Last update',
                        	'attribute' => 'updated_at'
                        	],
                        [
                        	'label' => 'Bets',
                        	'value' => function (Order $order) {
                        		return implode(', ', ArrayHelper::map($order->bets, 'id', 'name'));;
                        	}
                        	],
                        [
                        	'label' => 'Status',
                        	'attribute' => 'status',
                        	'format' => 'raw',
                        	'value' => function (Order $order) {
                        		return DynamicValue::widget([
                        			'data' => $order,
                        			'column' => 'status',
                        			'items' => [
                        				[
                        					'value' => Order::STATUS_ACTIVE,
                        					'link' => ['orders/approve', 'order' => $order->id, 'backUrl' => Url::current()],
                        					'label' => 'I\'ve got it!',
                        					'options' => [
                        						'class' => 'btn btn-success btn-block'
                        						]
                        					],
                        				[
                        					'value' => Order::STATUS_APPROVED_BY_ONE,
                        					'link' => Yii::$app->user->identity->id == $order->approved_by ? null : ['orders/approve', 'order' => $order->id, 'backUrl' => Url::current()],
                        					'tag' => 'div' ,
                        					'label' => Yii::$app->user->identity->id == $order->approved_by ? 'Waiting for partner' : 'I\'ve got it!',
                        					'options' => [
                        						'class' => Yii::$app->user->identity->id == $order->approved_by ? 'btn btn-info btn-block' : 'btn btn-success btn-block',
                        						]
                        					]
                        				]
                        			]);
                        	}
                        ],
                        
                    ]
				]);
                ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>