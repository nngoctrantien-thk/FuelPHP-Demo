<?php

namespace Fuel\Migrations;

class Create_books
{
	public function up()
	{
		\DBUtil::create_table('books', array(

			'id' => array(
				'type' => 'int',
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true,
				'constraint' => 11
			),

			'title' => array(
				'constraint' => 255,
				'null' => false,
				'type' => 'varchar'
			),

			'isbn' => array(
				'constraint' => 255,
				'null' => false,
				'type' => 'varchar'
			),

			'image' => array(
				'constraint' => 255,
				'type' => 'varchar',
				'null' => true
			),

			'author_id' => array(
				'constraint' => 11,
				'null' => false,
				'type' => 'int'
			),

			'category_id' => array(
				'constraint' => 11,
				'null' => false,
				'type' => 'int'
			),

			'total_copies' => array(
				'constraint' => 11,
				'null' => false,
				'type' => 'int'
			),

			'available_copies' => array(
				'constraint' => 11,
				'null' => false,
				'type' => 'int'
			),

			'created_at' => array(
				'constraint' => 11,
				'null' => false,
				'type' => 'int'
			),

			'updated_at' => array(
				'constraint' => 11,
				'null' => false,
				'type' => 'int'
			),

		),

		array('id'),

		array(
			array(
				'columns' => array('isbn'),
				'unique' => true,
			),

			array(
				'columns' => array('author_id'),
			),

			array(
				'columns' => array('category_id'),
			),
		));
	}

	public function down()
	{
		\DBUtil::drop_table('books');
	}
}