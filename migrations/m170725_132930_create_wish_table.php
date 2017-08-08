<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `wish`.
 */
class m170725_132930_create_wish_table extends Migration
{
	
	public function safeUp()
    {
        
        $this->createTable('{{%wish}}', [
        	'id' => $this->primaryKey(),
        	'user_id' => $this->integer()->notNull(),
        	'name' => $this->string()->notNull()
        	], $this->tableOptions);
        	
       	$this->createIndex('idx-wish-user_id', '{{%wish}}', 'user_id');
       	$this->addForeignKey('fk-wish-user-id', '{{%wish}}', 'user_id', '{{%user}}', 'id', $this->cascade, $this->restrict);
    	
    }

    public function safeDown()
    {
		 $this->dropTable('{{%wish}}');

    }
    /**
     * @inheritdoc
     */
    /*public function up()
    {
        $this->createTable('wish', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    /*public function down()
    {
        $this->dropTable('wish');
    }*/
}
