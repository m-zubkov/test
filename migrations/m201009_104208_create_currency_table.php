<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m201009_104208_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название валюты'),
            'code' => $this->string(3)->unique()->notNull()->comment('Код валюты'),
            'rate' => $this->decimal()->comment(''),
            'updated' => $this->dateTime()->defaultValue(new \yii\db\Expression('NOW()'))
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency}}');
    }
}
