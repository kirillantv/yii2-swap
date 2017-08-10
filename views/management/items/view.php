<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'author_id',
            'created_at',
            'update_at',
            'active:boolean',
        ],
    ]) ?>
    <p>
    	<?= Html::a('Add category', ['items-categories/create', 'item_id' => $model->id], ['class' => 'btn btn-primary']); ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider(['query' => $model->getItemCategories()]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            	'attribute' => 'category_id',
            	'label' => 'Category',
            	'value' => 'category.name'
            	],

            [
            	'class' => 'yii\grid\ActionColumn',
            	'controller' => 'items-categories'
            	],
        ],
    ]); ?>
    <p>
    	<?= Html::a('Add bet', ['items-bets/create', 'item_id' => $model->id], ['class' => 'btn btn-primary']); ?>
    </p>
    <?= GridView::widget([
    	'dataProvider' => new ActiveDataProvider(['query' => $model->getItemBets()]),
    	'columns' => [
    		[
    			'attribute' => 'bet_id',
    			'label' => 'Bet',
    			'value' => 'bet.name'
    			],
    		[
            	'class' => 'yii\grid\ActionColumn',
            	'controller' => 'items-bets'
            	],
    		],
    	]);
    ?>

</div>
