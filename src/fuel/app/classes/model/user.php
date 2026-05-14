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
        'is_active' => array(
            'default' => 0,
        ),
        'activation_token' => array(
            'default' => null,
        ),
        'last_login',
        'login_hash',
        'created_at',
        'updated_at',
    );

    /**
     * Tự động cập nhật thời gian created_at và updated_at
     */
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