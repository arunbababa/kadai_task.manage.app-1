<?php

namespace Fuel\Migrations;

class Create_users
{
	//usersテーブル
	public function up()
	{
		\DBUtil::create_table('users', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 100, 'type' => 'varchar'),
			'password_hash' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
    {
        \DBUtil::drop_table('users');
    }

	
}