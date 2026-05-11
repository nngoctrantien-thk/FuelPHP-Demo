<?php

class Controller_User_Borrows extends Controller_User
{

	/**
	 * =====================================================
	 * Borrow Book
	 * =====================================================
	 */

	public function action_create($book_id = null)
	{
		if (!$book_id) {
			Session::set_flash(
				'error',
				'Invalid book.'
			);

			return Response::redirect('user/books');
		}

		try {
			Service_BorrowService::borrow_book(
				Auth::get_user_id()[1],
				$book_id
			);

			Session::set_flash(
				'success',
				'Borrow book successfully.'
			);
		} catch (Exception $e) {
			Session::set_flash(
				'error',
				$e->getMessage()
			);
		}

		return Response::redirect('user/borrowed');
	}
	/**
	 * =====================================================
	 * Borrowed Books List
	 * =====================================================
	 */

	public function action_index()
	{
		$user_id = Auth::get_user_id()[1];

		$borrows = Model_Borrow::query()
			->related('book')
			->related('book.author')
			->where('user_id', $user_id)
			->where('status', 'borrowing')
			->order_by('id', 'desc')
			->get();

		$data['borrows'] = $borrows;

		$this->template->title = 'My Borrowed Books';

		$this->template->content = View::forge(
			'user/borrows/index',
			$data
		);
	}

	/**
	 * =====================================================
	 * Return Book
	 * =====================================================
	 */

	public function action_return($borrow_id = null)
	{
		if (!$borrow_id) {
			Session::set_flash(
				'error',
				'Invalid borrow record.'
			);

			return Response::redirect('user/borrows');
		}
		$borrow = Model_Borrow::find($borrow_id);

		if (!$borrow) {
			Session::set_flash(
				'error',
				'Borrow record not found.'
			);

			return Response::redirect('user/borrows');
		}
		if ($borrow->user_id != Auth::get_user_id()[1]) {
			Session::set_flash(
				'error',
				'Unauthorized access.'
			);

			return Response::redirect('user/borrows');
		}
		if ($borrow->status == 'returned') {
			Session::set_flash(
				'error',
				'Book already returned.'
			);

			return Response::redirect('user/borrows');
		}

		try {
			// update borrow

			$borrow->status = 'returned';

			$borrow->returned_at = time();

			$borrow->save();

			// update available copies

			$book = Model_Book::find($borrow->book_id);

			if ($book) {
				$book->available_copies += 1;

				$book->save();
			}

			Session::set_flash(
				'success',
				'Return book successfully.'
			);
		} catch (Exception $e) {
			Session::set_flash(
				'error',
				$e->getMessage()
			);
		}

		return Response::redirect('user/borrows');
	}
}
