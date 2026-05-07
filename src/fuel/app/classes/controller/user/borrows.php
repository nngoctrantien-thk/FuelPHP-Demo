<?php

class Controller_User_Borrows extends Controller_User
{

	public function action_borrow($book_id)
	{
		try {
			Service_BorrowService::borrow_book(
				Auth::get_user_id()[1],
				$book_id
			);

			Session::set_flash(
				'success',
				'Borrow success.'
			);
		} catch (Exception $e) {
			Session::set_flash(
				'error',
				$e->getMessage()
			);
		}

		Response::redirect('user/books');
	}
}
