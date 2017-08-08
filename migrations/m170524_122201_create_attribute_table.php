<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `attribute`.
 */
class m170524_122201_create_attribute_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        
        $this->createTable('{{%attribute}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'required' => $this->integer()->defaultValue(0)
        ], $this->tableOptions);
        
        $this->createIndex('idx-attribute-name', '{{%attribute}}', 'name');
        
        // Junction 
        
        $this->createTable('{{%value}}', [
        	'item_id' => $this->integer()->notNull(),
        	'attribute_id' => $this->integer()->notNull(),
        	'value_string' => $this->string(),
        	'value_number' => $this->integer()
        	], $this->tableOptions);
        	
        $this->addPrimaryKey('pk-value', '{{%value}}', ['item_id', 'attribute_id']);
        
        $this->createIndex('idx-value-item_id', '{{%value}}', 'item_id');
        $this->createIndex('idx-value-attribute_id', '{{%value}}', 'attribute_id');
        $this->createIndex('idx-value-value_string', '{{%value}}', 'value_string');
        $this->createIndex('idx-value-value_number', '{{%value}}', 'value_number');
        
        $this->addForeignKey('fk-value-item', '{{%value}}', 'item_id', '{{%item}}', 'id', $this->cascade, $this->restrict);
        $this->addForeignKey('fk-value-attribute', '{{%value}}', 'attribute_id', '{{%attribute}}', 'id', $this->cascade, $this->restrict);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    	$this->dropTable('{{%value}}');
        $this->dropTable('{{%attribute}}');
    }
}
