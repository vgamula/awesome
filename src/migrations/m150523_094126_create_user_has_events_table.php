<?php

use yii\db\Migration;
use yii\db\Schema;

class m150523_094126_create_user_has_events_table extends Migration
{
    protected $tableName = '{{%user_has_events}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'userId' => Schema::TYPE_INTEGER,
            'eventId' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->addPrimaryKey('user_has_events_pk', $this->tableName, [
            'userId',
            'eventId',
        ]);
    }

    public function down()
    {
        $this->dropPrimaryKey('user_has_events_pk', $this->tableName);
        $this->dropTable($this->tableName);
        return true;
    }
}
