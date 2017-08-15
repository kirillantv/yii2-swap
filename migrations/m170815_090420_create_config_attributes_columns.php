<?php
use kirillantv\swap\migrations\Migration;
/**
 * Class m170815_090420_create_config_attributes_columns
 */
class m170815_090420_create_config_attributes_columns extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('{{%attribute}}', 'searchable', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
         $this->dropColumn('{{%attribute}}', 'searchable');
         
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170815_090420_create_config_attributes_columns cannot be reverted.\n";

        return false;
    }
    */
}
