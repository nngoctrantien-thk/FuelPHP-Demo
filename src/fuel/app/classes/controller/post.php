<?php

use Fuel\Core\DB;

class Controller_Post extends Controller_Template
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
		$data["lstPosts"] = Model_Post::find('all');
		$data["lstPostsQuery"] = DB::select()->from('posts')->where('id', '>', 3)->execute()->as_array();
		$this->template->title = 'Post &raquo; Index';
		$this->template->content = View::forge('post/index', $data);
	}

	public function action_create()
	{
		$data["subnav"] = array('create' => 'active');
		$this->template->title = 'Post &raquo; Create';
		$this->template->content = View::forge('post/create', $data);
	}

	public function action_update()
	{
		$data["subnav"] = array('update' => 'active');
		$this->template->title = 'Post &raquo; Update';
		$this->template->content = View::forge('post/update', $data);
	}

	public function action_delete()
	{
		$data["subnav"] = array('delete' => 'active');
		$this->template->title = 'Post &raquo; Delete';
		$this->template->content = View::forge('post/delete', $data);
	}
}
