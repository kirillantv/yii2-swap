<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\Menu;
use yii\helpers\Url;

$this->title = 'My items';

$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => $model,
    'pagination' => [
        'pageSize' => 20,
    ],
]);
$items = [
		['label' => 'Active', 'url' => ['user/items/active']],
		['label' => 'Archive', 'url' => ['user/items/archive']],
	];
Url::remember();
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
                <?= GridView::widget([
				    'dataProvider' => $dataProvider,
                                    'columns'   => [
                                        [
                                            'label' => 'Item id',
                                            'attribute' => 'id'
                                        ],
                                        'title',
                                        [
                                            'label' => 'Creation time',
                                            'attribute' => 'created_at'
                                        ],
                                        [
                                            'label' => 'Status',
                                            'attribute' => 'active',
                                            'value' => function ($data) {
                                                return $data->active == 1 ? Html::encode('Active') : Html::encode('Swapped');
                                            }
                                        ],
                                        [
                                        	'label' => 'Management',
                                        	'format' => 'raw',
                                        	'value' => function ($data){
                                        		return Html::a('Delete', ['items/delete', 'id' => $data->id]).
                                        		Html::tag('br').
                                        		Html::a('Edit', ['items/edit', 'id' => $data->id]);
                                        	}
                                        	]
                                    ]
				]);
                ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>