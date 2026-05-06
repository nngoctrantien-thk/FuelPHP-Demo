<?php

namespace Fuel\Migrations;

class Create_users
{
    public function up()
    {
        \DBUtil::create_table('users', array(
            'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => 11),
            'username' => array('constraint' => 50, 'null' => false, 'type' => 'varchar'),
            'password' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
            'group' => array('constraint' => 11, 'null' => false, 'type' => 'int', 'default' => 1), // Mặc định group 1
            'email' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
            'last_login' => array('constraint' => 25, 'null' => false, 'type' => 'varchar', 'default' => 0), // Thêm default 0
            'login_hash' => array('constraint' => 255, 'null' => false, 'type' => 'varchar', 'default' => ''), // Thêm default rỗng
            'profile_fields' => array('null' => false, 'type' => 'text'),
            'created_at' => array('constraint' => 11, 'null' => false, 'type' => 'int', 'default' => 0),
            'updated_at' => array('constraint' => 11, 'null' => false, 'type' => 'int', 'default' => 0), // Sửa lỗi ở đây
        ), array('id'));

        // Thêm index Unique cho username và email để đảm bảo không bị trùng lặp
        \DBUtil::create_index('users', array('username', 'email'), 'username_email_unique', 'unique');
    }

    public function down()
    {
        \DBUtil::drop_table('users');
    }
}