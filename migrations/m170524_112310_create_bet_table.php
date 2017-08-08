<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `bet`.
 */
class m170524_112310_create_bet_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%bet}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ], $this->tableOptions);
        
        $this->createIndex('idx-bet-name', '{{%bet}}', 'name');
        
        // Junction
        
        $this->createTable('{{%item_bet}}', [
        	'item_id' => $this->integer()->notNull(),
        	'bet_id' => $this->integer()->notNull()
        	], $this->tableOptions);
        	
        $this->addPrimaryKey('pk-item_bet', '{{%item_bet}}', ['item_id', 'bet_id']);
        	
        $this->createIndex('idx-item_bet-item_id', '{{%item_bet}}', 'item_id');
        $this->createIndex('idx-item_bet-bet_id', '{{%item_bet}}', 'bet_id');
        
        $this->addForeignKey('fk-item_bet-item', '{{%item_bet}}', 'item_id', '{{%item}}', 'id', $this->cascade, $this->restrict);
        $this->addForeignKey('fk-item_bet-bet', '{{%item_bet}}', 'bet_id', '{{%bet}}', 'id', $this->cascade, $this->restrict);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    	$this->dropTable('{{%item_bet}}');
        $this->dropTable('{{%bet}}');
    }
}
