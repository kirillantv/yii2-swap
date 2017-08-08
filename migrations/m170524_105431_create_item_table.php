<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `item`.
 */
class m170524_105431_create_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        
        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'update_at' => $this->datetime(),
            'active' => $this->integer()->defaultValue(1)
        ], $this->tableOptions);
        
        $this->createIndex('idx-item-author_id', '{{%item}}', 'author_id');
        $this->createIndex('idx-item-active', '{{%item}}', 'active');
        
        
        // Junction
        
        $this->createTable('{{%item_category}}', [
        	'item_id' => $this->integer()->notNull(),
        	'category_id' => $this->integer()->notNull()
        	], $this->tableOptions);
        	
        $this->addPrimaryKey('pk-item_category', '{{%item_category}}', ['item_id', 'category_id']);	
        
        $this->createIndex('idx-item_category-item_id', '{{%item_category}}', 'item_id');
        $this->createIndex('idx-item_category-category_id', '{{%item_category}}', 'category_id');
        
        $this->addForeignKey('fk-item_category-item', '{{%item_category}}', 'item_id', '{{%item}}', 'id', $this->cascade, $this->restrict);
        $this->addForeignKey('fk-item_category-category', '{{%item_category}}', 'category_id', '{{%category}}', 'id', $this->cascade, $this->restrict);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%item}}');
        $this->dropTable('{{%item_category}}');
    }
}
