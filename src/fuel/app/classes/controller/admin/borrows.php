<?php

class Controller_Admin_Borrows extends Controller_Admin
{

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'Admin/borrows &raquo; Index';
		$this->template->content = View::forge('admin/borrows/index', $data);
	}

	public function action_view()
	{
		$data["subnav"] = array('view'=> 'active' );
		$this->template->title = 'Admin/borrows &raquo; View';
		$this->template->content = View::forge('admin/borrows/view', $data);
	}

	public function action_create()
	{
		$data["subnav"] = array('create'=> 'active' );
		$this->template->title = 'Admin/borrows &raquo; Create';
		$this->template->content = View::forge('admin/borrows/create', $data);
	}

	public function action_edit()
	{
		$data["subnav"] = array('edit'=> 'active' );
		$this->template->title = 'Admin/borrows &raquo; Edit';
		$this->template->content = View::forge('admin/borrows/edit', $data);
	}

	public function action_delete()
	{
		$data["subnav"] = array('delete'=> 'active' );
		$this->template->title = 'Admin/borrows &raquo; Delete';
		$this->template->content = View::forge('admin/borrows/delete', $data);
	}

}
