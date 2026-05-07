<?php

class Controller_User_Books extends Controller_User
{

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'User/books &raquo; Index';
		$this->template->content = View::forge('user/books/index', $data);
	}

	public function action_view()
	{
		$data["subnav"] = array('view'=> 'active' );
		$this->template->title = 'User/books &raquo; View';
		$this->template->content = View::forge('user/books/view', $data);
	}

}
