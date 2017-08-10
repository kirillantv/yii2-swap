<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrderBet */

$this->title = 'Create Order Bet';
$this->params['breadcrumbs'][] = ['label' => 'Order Bets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-bet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
