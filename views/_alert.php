<?php

/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */

use yii\bootstrap\Alert;

/**
 * @var dektrium\user\Module $module
 */
?>

<div class="row">
    <div class="col-xs-12">
        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
            <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])):  ?>
                <?= Alert::widget([
                    'options' => ['class' => 'alert-dismissible alert-' . $type],
                    'body' => $message
                ]) ?>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</div>
