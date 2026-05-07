<?php
use Orm\Model;

class Model_Borrow extends Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'book_id',
		'borrowed_at',
		'due_date',
		'returned_at',
		'status',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('user_id', 'User Id', 'required|valid_string[numeric]');
		$val->add_field('book_id', 'Book Id', 'required|valid_string[numeric]');
		$val->add_field('borrowed_at', 'Borrowed At', 'required|valid_string[numeric]');
		$val->add_field('due_date', 'Due Date', 'required|valid_string[numeric]');
		$val->add_field('returned_at', 'Returned At', 'required|valid_string[numeric]');
		$val->add_field('status', 'Status', 'required|max_length[255]');

		return $val;
	}

}
