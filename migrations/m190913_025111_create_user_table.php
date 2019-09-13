<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190913_025111_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'balance' => $this->double()->notNull()->defaultValue(0.00),
        ], $tableOptions);

        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%user}}',['id'=>'1','username'=>'admin','auth_key'=>'Ht2WPMpceorgpl3MpljOEbrWcBrgCunp','password_hash'=>'$2y$13$Y2zfvoI9tV5clCsxvwLE8.bNu07BzhQdPc2e0eE0kMXgIxLvgreDe','password_reset_token'=>'','email'=>'admin@devreadwrite.com','status'=>'10','created_at'=>'1568351584','updated_at'=>'1568351629','balance'=>'0']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
