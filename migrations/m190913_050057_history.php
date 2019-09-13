<?php

use yii\db\Migration;

/**
 * Class m190913_050057_history
 */
class m190913_050057_history extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $tableOptions_mssql = "";
        $tableOptions_pgsql = "";
        $tableOptions_sqlite = "";
        /* MYSQL */
        if (!in_array('history', $tables))  { 
        if ($dbType == "mysql") {
            $this->createTable('{{%history}}', [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                0 => 'PRIMARY KEY (`id`)',
                'sender_user_id' => 'INT(11) NOT NULL',
                'receiver_user_id' => 'INT(11) NOT NULL',
                'amount' => 'DOUBLE NOT NULL',
                'sender_old_balance' => 'DOUBLE NOT NULL',
                'sender_new_balance' => 'DOUBLE NOT NULL',
                'receiver_old_balance' => 'DOUBLE NOT NULL',
                'receiver_new_balance' => 'DOUBLE NOT NULL',
                'created_date' => 'DATETIME NOT NULL',
            ], $tableOptions_mysql);
        }
        }
         
         
        $this->createIndex('idx_sender_user_id_6244_00','history','sender_user_id',0);
        $this->createIndex('idx_receiver_user_id_6245_01','history','receiver_user_id',0);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `history`');
        $this->execute('SET foreign_key_checks = 1;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190913_050057_history cannot be reverted.\n";

        return false;
    }
    */
}
