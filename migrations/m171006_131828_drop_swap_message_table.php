<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `swap_message`.
 */
class m171006_131828_drop_swap_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
    	$this->dropForeignKey(
            'fk-swap_message-from-user',
            '{{%swap_message}}'
        );
        $this->dropForeignKey(
            'fk-swap_message-to-user',
            '{{%swap_message}}'
        );
        $this->dropForeignKey(
            'fk-swap_message-item',
            '{{%swap_message}}'
        );
        $this->dropTable('{{%swap_message}}');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->createTable('{{%swap_message}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
