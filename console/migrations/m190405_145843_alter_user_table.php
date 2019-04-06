<?php

use yii\db\Migration;


class m190405_145843_alter_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->addColumn('{{%user}}','about', $this->text());
        $this->addColumn('{{%user}}','type', $this->integer(3));
        $this->addColumn('{{%user}}','nickname', $this->string(70));
        $this->addColumn('{{%user}}','picture', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropColumn('{{%user}}','picture');
        $this->dropColumn('{{%user}}','nickname');
        $this->dropColumn('{{%user}}','type');
        $this->dropColumn('{{%user}}','about');
    }
}
