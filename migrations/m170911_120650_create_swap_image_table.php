<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `{{%swap_image}}`.
 */
class m170911_120650_create_swap_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%swap_image}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string(),
            'item_id' => $this->integer()
        ], $this->tableOptions);
        
        $this->createIndex('idx-swap_image-item_id', '{{%swap_image}}', 'item_id');
       	$this->addForeignKey('fk-swap_image-item_id', '{{%swap_image}}', 'item_id', '{{%item}}', 'id', $this->setNull, $this->restrict);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%swap_image}}');
    }
}
