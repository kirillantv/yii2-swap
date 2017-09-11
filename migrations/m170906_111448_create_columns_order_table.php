<?php

use kirillantv\swap\migrations\Migration;

/**
 * Creates 'created_at', 'updated_at', 'approved_by' columns in 'Order' table
 */
class m170906_111448_create_columns_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'created_at', $this->datetime());
        $this->addColumn('{{%order}}', 'updated_at', $this->datetime());
        $this->addColumn('{{%order}}', 'approved_by', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'created_at');
        $this->dropColumn('{{%order}}', 'updated_at');
        $this->dropColumn('{{%order}}', 'approved_by');
    }
}
