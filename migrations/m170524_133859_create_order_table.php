<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170524_133859_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'catcher_id' => $this->integer()->notNull(),
            'status' => $this->integer()->defaultValue(1)
        ], $this->tableOptions);
        
        $this->createIndex('idx-order-item_id', '{{%order}}', 'item_id');
        $this->createIndex('idx-order-catcher_id', '{{%order}}', 'catcher_id');
        $this->createIndex('idx-order-status', '{{%order}}', 'status');
        
        $this->addForeignKey('fk-order-item_id', '{{%order}}', 'item_id', '{{%item}}', 'id', $this->cascade, $this->restrict);
        
        // Junction
        
        $this->createTable('{{%order_bet}}', [
        	'order_id' => $this->integer()->notNull(),
        	'bet_id' => $this->integer()->notNull()
        	], $this->tableOptions);
        
        $this->addPrimaryKey('pk-order_bet', '{{%order_bet}}', ['order_id', 'bet_id']);
        
        $this->createIndex('idx-order_bet-order_id', '{{%order_bet}}', 'order_id');
        $this->createIndex('idx-order_bet-bet_id', '{{%order_bet}}', 'bet_id');
        
        $this->addForeignKey('fk-order_bet-order', '{{%order_bet}}', 'order_id', '{{%order}}', 'id', $this->cascade, $this->restrict);
        $this->addForeignKey('fk-order_bet-bet', '{{%order_bet}}', 'bet_id', '{{%bet}}', 'id', $this->cascade, $this->restrict);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    	$this->dropTable('{{%order_bet}}');
        $this->dropTable('{{%order}}');
    }
}
