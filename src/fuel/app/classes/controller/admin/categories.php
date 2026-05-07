<?php

class Controller_Admin_Categories extends Controller_Admin
{

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'Admin/categories &raquo; Index';
		$this->template->content = View::forge('admin/categories/index', $data);
	}

	public function action_view()
	{
		$data["subnav"] = array('view'=> 'active' );
		$this->template->title = 'Admin/categories &raquo; View';
		$this->template->content = View::forge('admin/categories/view', $data);
	}

	public function action_create()
	{
		$data["subnav"] = array('create'=> 'active' );
		$this->template->title = 'Admin/categories &raquo; Create';
		$this->template->content = View::forge('admin/categories/create', $data);
	}

	public function action_edit()
	{
		$data["subnav"] = array('edit'=> 'active' );
		$this->template->title = 'Admin/categories &raquo; Edit';
		$this->template->content = View::forge('admin/categories/edit', $data);
	}

	public function action_delete()
	{
		$data["subnav"] = array('delete'=> 'active' );
		$this->template->title = 'Admin/categories &raquo; Delete';
		$this->template->content = View::forge('admin/categories/delete', $data);
	}

}
