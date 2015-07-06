<?php

use yii\db\Schema;
use yii\db\Migration;

class m150704_174115_create_table_comment extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        // MySql table options
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        // Rate models table
        $this->createTable('{{%comment}}', [
            'comm_id' =>  Schema::TYPE_PK . ' NOT NULL AUTO_INCREMENT',
            'comm_parent' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
            'comm_content' => Schema::TYPE_TEXT . ' NOT NULL',
            'comm_status' => Schema::TYPE_STRING . '(16) NOT NULL',
            'comm_ip' => Schema::TYPE_STRING . '(128) NOT NULL',
            'comm_agent' => Schema::TYPE_STRING . '(255) NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
            'model_table' => Schema::TYPE_STRING . '(64) NOT NULL',
            'model_pk' => Schema::TYPE_STRING . '(16) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        // Create indexes
        $this->createIndex('comm_parent', '{{%comment}}', 'comm_parent');
        $this->createIndex('comm_status', '{{%comment}}', 'comm_status');
        $this->createIndex('user_id', '{{%comment}}', 'user_id');
        $this->createIndex('model_table', '{{%comment}}', 'model_table');
        $this->createIndex('model_pk', '{{%comment}}', 'model_pk');
    }

    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
