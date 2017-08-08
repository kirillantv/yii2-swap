<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `category`.
 */
class m170524_101850_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'parent_id' => $this->integer()
        ], $this->tableOptions);
        
        $this->createIndex('idx-category-parent_id', '{{%category}}', 'parent_id');
        
        $this->addForeignKey('fk-category-parent', '{{%category}}', 'parent_id', '{{%category}}', 'id', $this->setNull, $this->restrict);
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%category}}');
    }
}
