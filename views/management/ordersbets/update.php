<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrderBet */

$this->title = 'Update Order Bet: ' . $model->item_id;
$this->params['breadcrumbs'][] = ['label' => 'Order Bets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_id, 'url' => ['view', 'item_id' => $model->item_id, 'bet_id' => $model->bet_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-bet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
