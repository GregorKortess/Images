<?php

use yii\db\Migration;

/**
 * Class m190423_142855_alter_table_post_add_column_complaints
 */
class m190423_142855_alter_table_post_add_column_complaints extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->addColumn('{{%post}}','complaints',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
       $this->dropColumn('{{%post}}','complaints');
    }


}
