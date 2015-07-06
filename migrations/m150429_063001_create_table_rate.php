<?php

use yii\db\Schema;
use yii\db\Migration;

class m150429_063001_create_table_rate extends Migration
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
        $this->createTable('{{%rate}}', [
            'rate_id' =>  Schema::TYPE_PK . ' NOT NULL AUTO_INCREMENT',
            'model_table' => Schema::TYPE_STRING . '(64) NOT NULL',
            'model_pk' => Schema::TYPE_STRING . '(16) NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
            'rating' => Schema::TYPE_DECIMAL . '(5,2) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        // Create indexes
        $this->createIndex('model_table', '{{%rate}}', 'model_table');
        $this->createIndex('model_pk', '{{%rate}}', 'model_pk');
        $this->createIndex('user_id', '{{%rate}}', 'user_id');
        $this->createIndex('rating', '{{%rate}}', 'rating');
    }

    public function safeDown()
    {
        $this->dropTable('{{%rate}}');
    }
}
