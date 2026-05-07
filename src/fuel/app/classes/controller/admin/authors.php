<?php

class Controller_Admin_Authors extends Controller_Admin
{

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'Admin/authors &raquo; Index';
		$this->template->content = View::forge('admin/authors/index', $data);
	}

	public function action_view()
	{
		$data["subnav"] = array('view'=> 'active' );
		$this->template->title = 'Admin/authors &raquo; View';
		$this->template->content = View::forge('admin/authors/view', $data);
	}

	public function action_create()
	{
		$data["subnav"] = array('create'=> 'active' );
		$this->template->title = 'Admin/authors &raquo; Create';
		$this->template->content = View::forge('admin/authors/create', $data);
	}

	public function action_edit()
	{
		$data["subnav"] = array('edit'=> 'active' );
		$this->template->title = 'Admin/authors &raquo; Edit';
		$this->template->content = View::forge('admin/authors/edit', $data);
	}

	public function action_delete()
	{
		$data["subnav"] = array('delete'=> 'active' );
		$this->template->title = 'Admin/authors &raquo; Delete';
		$this->template->content = View::forge('admin/authors/delete', $data);
	}

}
