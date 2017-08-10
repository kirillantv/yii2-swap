<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Bet */

$this->title = 'Create Bet';
$this->params['breadcrumbs'][] = ['label' => 'Bets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
