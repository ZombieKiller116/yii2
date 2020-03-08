<?php

use yii\db\Migration;

class m200226_190718_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(60)->unique()->notNull(),
            'password' => $this->string(255)->notNull(),
            'access_token' => $this->string(60)->notNull(),
            'role' => $this->integer(11)->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'email_confirm_token' => $this->string()->unique(),
            'name' => $this->string(15)->notNull(),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
