<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\Menu;
use yii\helpers\Url;
use kirillantv\dynamicvalue\DynamicValue;

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
                            'label' => 'Status',
                            'attribute' => 'status',
                            'value' => function ($data) {
                                return $data->status == 1 ? Html::encode('In process') : Html::encode('Archive');
                            }
                        ],
                        [
                        	'label' => 'Manage',
                        	'format' => 'raw',
                        	'value' => function ($data) {
                        		return DynamicValue::widget([
                        			'data' => $data,
                        			'column' => 'status',
                        			'items' => [
                        				[
                        					'value' => 1,
                        					'link' => ['orders/create', 'id' => $data->id],
                        					'tag' => 'span',
                        					'label' => "I've got it!",
                        					'options' => [
                        						'class' => 'btn btn-success btn-block'
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