<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `swap_message`.
 */
class m171006_132529_create_swap_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%swap_message}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'ip' => $this->string(30)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'status' => $this->integer()->notNull(),
            'conversation_id' => $this->integer()->notNull()
        ], $this->tableOptions);
        
        $this->createIndex('idx-swap_message-user_id', '{{%swap_message}}', 'user_id');
        $this->createIndex('idx-swap_message-status', '{{%swap_message}}', 'status');
        $this->createIndex('idx-swap_message-conversation_id', '{{%swap_message}}', 'conversation_id');
        
        $this->addForeignKey('fk-swap_message-user', '{{%swap_message}}', 'user_id', '{{%user}}', 'id', $this->restrict, $this->restrict);
        $this->addForeignKey('fk-swap_message-swap_conversation', '{{%swap_message}}', 'conversation_id', '{{%swap_conversation}}', 'id', $this->restrict, $this->restrict);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
    	$this->dropForeignKey('fk-swap_message-user','{{%swap_message}}');
    	$this->dropForeignKey('fk-swap_message-swap_conversation','{{%swap_message}}');
        $this->dropTable('{{%swap_message}}');
    }
}
