<?php

class Controller_User_Profile extends Controller_User
{

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'User/profile &raquo; Index';
		$this->template->content = View::forge('user/profile/index', $data);
	}

	public function action_edit()
	{
		$data["subnav"] = array('edit'=> 'active' );
		$this->template->title = 'User/profile &raquo; Edit';
		$this->template->content = View::forge('user/profile/edit', $data);
	}

}
