<?php

use yii\db\Migration;
use yii\db\Schema;

class m150523_092944_create_events_table extends Migration
{
    protected $tableName = '{{%events}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'userId' => Schema::TYPE_INTEGER,
            'description' => Schema::TYPE_TEXT,
            'photos' => Schema::TYPE_TEXT,
            'start' => Schema::TYPE_DATETIME,
            'end' => Schema::TYPE_DATETIME,
            'lat' => Schema::TYPE_FLOAT,
            'lng' => Schema::TYPE_FLOAT,
            'placeName' => Schema::TYPE_STRING,
            'visible' => Schema::TYPE_SMALLINT,
            'status' => Schema::TYPE_SMALLINT,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable($this->tableName);
        return true;
    }
}
