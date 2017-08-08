<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles the creation of table `basic_config`.
 */
class m170530_230343_create_basic_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%basic_config}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'value' => $this->string()
        ], $this->tableOptions);
        
        $this->insert('{{%basic_config}}', ['name' => 'isCustomTitle']);
        $this->insert('{{%basic_config}}', ['name' => 'customTitleFormula']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%basic_config}}');
    }
}
