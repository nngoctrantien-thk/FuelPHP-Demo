<?php

class Controller_User_Books extends Controller_User
{
	public function action_view($id = null)
	{
		$data["subnav"] = array(
			'view' => 'active'
		);

		$book = Model_Book::find($id);
		if (!$book)
		{
			Session::set_flash(
				'error',
				'Book not found.'
			);

			return Response::redirect('/user/books');
		}

		$book->category_name = $book->category
			? $book->category->category_name
			: 'Uncategorized';

		$data['book'] = $book;

		$this->template->title = 'Book View';

		$this->template->content = View::forge(
			'user/books/view',
			$data
		);
	}

}