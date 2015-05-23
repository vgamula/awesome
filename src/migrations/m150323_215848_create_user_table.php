<?php

use yii\db\Schema;
use yii\db\Migration;

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
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'firstName' => Schema::TYPE_STRING . ' NULL',
            'lastName' => Schema::TYPE_STRING . ' NULL',
            'isActive' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'role' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'passwordHash' => Schema::TYPE_STRING . ' NOT NULL',
            'passwordResetToken' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'passwordResetExpire' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'emailConfirmToken' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'emailConfirmed' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
        return true;
    }

}
