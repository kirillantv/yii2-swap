<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ItemBet */

$this->title = $model->item_id;
$this->params['breadcrumbs'][] = ['label' => 'Item Bets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-bet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'item_id' => $model->item_id, 'bet_id' => $model->bet_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'item_id' => $model->item_id, 'bet_id' => $model->bet_id], [
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
            'item_id',
            'bet_id',
        ],
    ]) ?>

</div>
