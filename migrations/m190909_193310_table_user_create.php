<?php

use yii\db\Migration;

/**
 * Class m190909_193310_table_user_create
 */
class m190909_193310_table_user_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(150)->notNull()->unique(),
            'password' => $this->string(300)->notNull(),
            'auth_token' => $this->string(300)->notNull()->unique(),
            'date_create' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_update' => $this->dateTime(),
            'active' => $this->string(1),
            'name' => $this->string(300),
            'second_name' => $this->string(300),
            'last_name' => $this->string(300),
            'personal_phone' => $this->string(20)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190909_193310_table_user_create cannot be reverted.\n";

        return false;
    }
    */
}
