<?php

namespace Fuel\Migrations;

class Create_tags
{
	//tagsテーブル
	public function up()
	{
		\DBUtil::create_table('tags', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
    {
        \DBUtil::drop_table('tags');
    }

}