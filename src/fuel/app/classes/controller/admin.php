<?php

class Controller_Admin extends Controller_Template
{
    public $template = 'admin/template';

    public function before()
    {
        parent::before();

        if (!\Auth::check())
        {
            \Response::redirect('auth/login');
        }

        if (\Auth::get('group') != 100)
        {
            \Response::redirect('/');
        }
    }

    public function action_index()
    {
        $data['books'] = \Model_Book::find('all');

        $data['total_books'] =
            \Model_Book::count();

        $data['total_authors'] =
            \Model_Author::count();

        $data['total_categories'] =
            \Model_Category::count();

        $data['total_borrows'] =
            \Model_Borrow::count();

        $this->template->title =
            'Admin Dashboard';

        $this->template->content =
            \View::forge('admin/index', $data);
    }
}