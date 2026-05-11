<?php

use Orm\Model;

class Model_User extends Model
{
	protected static $_table_name = 'users';

	protected static $_properties = array(
		'id',
		'username',
		'password',
		'email',
		'group',
		'profile_fields',
		'last_login',
		'login_hash',
		'created_at',
		'updated_at',
	);

	/**
	 * =====================================================
	 * RELATIONSHIPS
	 * =====================================================
	 */

	protected static $_has_many = array(

		'borrows' => array(
			'model_to' => 'Model_Borrow',
			'key_from' => 'id',
			'key_to'   => 'user_id',
		),

	);
}