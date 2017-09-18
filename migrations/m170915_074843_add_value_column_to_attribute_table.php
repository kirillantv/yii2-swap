<?php

use kirillantv\swap\migrations\Migration;

/**
 * Handles adding value to table `attribute`.
 */
class m170915_074843_add_value_column_to_attribute_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
    	$this->addColumn('{{%attribute}}', 'value', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
    	$this->dropColumn('{{%attribute}}', 'value');
    }
}
