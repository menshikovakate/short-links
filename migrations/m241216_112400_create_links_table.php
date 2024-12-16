<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%links}}`.
 */
class m241216_112400_create_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%links}}', [
            'id' => $this->primaryKey(),
            'full_link' => $this->string(500)->notNull(),
            'token' => $this->string(15)->notNull()->unique(),
            'counter' => $this->integer()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%links}}');
    }
}
