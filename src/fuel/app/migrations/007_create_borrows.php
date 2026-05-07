<?php

namespace Fuel\Migrations;

class Create_borrows
{
	public function up()
	{
		\DBUtil::create_table('borrows', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'user_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'book_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'borrowed_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'due_date' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'returned_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'status' => array('constraint' => '255', 'null' => false, 'type' => 'varchar'),
			'created_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'updated_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('borrows');
	}
}