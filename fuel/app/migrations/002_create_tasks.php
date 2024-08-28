<?php

namespace Fuel\Migrations;

class Create_tasks
{
	//tasksテーブル
	public function up()
	{
		\DBUtil::create_table('tasks', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'description' => array('type' => 'text'),
			'status' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'priority' => array('constraint' => 11, 'type' => 'int'),
			'due_date' => array('type' => 'date'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
    {
        \DBUtil::drop_table('tasks');
    }

}