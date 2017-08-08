<?php

use yii\db\Migration;

class m170721_093031_create_foreigh_hey extends Migration
{
    public function safeUp()
    {
        $this->addForeignKey('fk-order-catcher_id', '{{%order}}', 'catcher_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        
        $this->addForeignKey('fk-item-user', '{{%item}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        echo "m170721_093031_create_foreigh_hey cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170721_093031_create_foreigh_hey cannot be reverted.\n";

        return false;
    }
    */
}
