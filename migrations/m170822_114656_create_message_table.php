<?php

use kirillantv\swap\migrations\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `message`.
 */
class m170822_114656_create_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%swap_message}}', [
            'id' => Schema::TYPE_PK,
            'hash' => Schema::TYPE_STRING . '(32) NOT NULL',
            'from'                 => Schema::TYPE_INTEGER,
            'to'                   => Schema::TYPE_INTEGER,
            'status'               => Schema::TYPE_INTEGER,
            'item_id'			   => Schema::TYPE_INTEGER,
            'message'              => Schema::TYPE_TEXT,
            'created_at'           => Schema::TYPE_DATETIME . ' NOT NULL',
        ], $this->tableOptions);
        
        $this->createIndex('idx-swap_message-item_id', '{{%swap_message}}', 'item_id');
        $this->createIndex('idx-swap_message-hash', '{{%swap_message}}', 'hash');
        $this->createIndex('idx-swap_message-from', '{{%swap_message}}', 'from');
        $this->createIndex('idx-swap_message-to', '{{%swap_message}}', 'to');
        
        $this->addForeignKey('fk-swap_message-from-user', '{{%swap_message}}', 'from', '{{%user}}', 'id', $this->setNull, $this->restrict);
        $this->addForeignKey('fk-swap_message-to-user', '{{%swap_message}}', 'to', '{{%user}}', 'id', $this->setNull, $this->restrict);
        $this->addForeignKey('fk-swap_message-item', '{{%swap_message}}', 'item_id', '{{%item}}', 'id', $this->setNull, $this->restrict);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%swap_message}}');
    }
}
