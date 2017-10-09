<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `swap_conversation`.
 */
class m171006_132419_create_swap_conversation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%swap_conversation}}', [
            'id' => $this->primaryKey(),
            'user_one' => $this->integer()->notNull(),
            'user_two' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull()
        ], $this->tableOptions);
        
        $this->createIndex('idx-swap_conversation-user_one', '{{%swap_conversation}}', 'user_one');
        $this->createIndex('idx-swap_conversation-user_two', '{{%swap_conversation}}', 'user_two');
        $this->createIndex('idx-swap_conversation-item_id', '{{%swap_conversation}}', 'item_id');
        
        $this->addForeignKey('fk-swap_conversation-user-one', '{{%swap_conversation}}', 'user_one', '{{%user}}', 'id', $this->restrict, $this->restrict);
        $this->addForeignKey('fk-swap_conversation-user-two', '{{%swap_conversation}}', 'user_two', '{{%user}}', 'id', $this->restrict, $this->restrict);
        $this->addForeignKey('fk-swap_conversation-item', '{{%swap_conversation}}', 'item_id', '{{%item}}', 'id', $this->restrict, $this->restrict);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
    	$this->dropForeignKey('fk-swap_conversation-user-one','{{%swap_conversation}}');
    	$this->dropForeignKey('fk-swap_conversation-user-two','{{%swap_conversation}}');
    	$this->dropForeignKey('fk-swap_conversation-item','{{%swap_conversation}}');
        $this->dropTable('{{%swap_conversation}}');
    }
}
