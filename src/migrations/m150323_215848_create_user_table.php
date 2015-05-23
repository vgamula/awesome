<?php

use yii\db\Migration;
use yii\db\Schema;

class m150323_215848_create_user_table extends Migration
{
    protected $tableName = '{{%users}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NULL',
            'facebookId' => Schema::TYPE_STRING . ' NULL',
            'twitterId' => Schema::TYPE_STRING . ' NULL',
            'googleId' => Schema::TYPE_STRING . ' NULL',
            'avatar' => Schema::TYPE_STRING,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'remindeBefore' => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'email' => Schema::TYPE_STRING . ' NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
        return true;
    }

}
