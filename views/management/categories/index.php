<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kirillantv\swap\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'slug',
            'name',
            [
            	'attribute' => 'parent_id',
            	'filter' => Category::find()->select(['name', 'id'])->indexBy('id')->column(),
            	'value' => 'parent.name'
            	],
            [	'label' => 'Items',
            	'attribute' =>'items_count'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
