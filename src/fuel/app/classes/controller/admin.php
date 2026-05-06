<?php

use Fuel\Core\DB;

class Controller_Admin extends Controller_Template
{

	public function before()
	{
		parent::before();

		if (!Auth::check()) {
			Response::redirect('auth/login');
		}
	}
	public function action_index()
	{
		$data["subnav"] = array('index' => 'active');
		$data["lstAdmin"] = Model_Admin::find('all');
		$data["lstAdminQuery"] = DB::select()->from('admins')->where('id', '>', 3)->execute()->as_array();
		$this->template->title = 'Admin &raquo; Index';
		$this->template->content = View::forge('admin/index', $data);
	}

	public function action_create()
	{
		$data["subnav"] = array('create' => 'active');
		$this->template->title = 'Admin &raquo; Create';
		$this->template->content = View::forge('admin/create', $data);
	}

	public function action_update()
	{
		$data["subnav"] = array('update' => 'active');
		$this->template->title = 'Admin &raquo; Update';
		$this->template->content = View::forge('admin/update', $data);
	}

	public function action_delete()
	{
		$data["subnav"] = array('delete' => 'active');
		$this->template->title = 'Admin &raquo; Delete';
		$this->template->content = View::forge('admin/delete', $data);
	}
}
