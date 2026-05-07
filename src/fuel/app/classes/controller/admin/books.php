<?php

class Controller_Admin_Books extends Controller_Admin
{
	/*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

	public function action_index()
	{

		$data['books'] =
			Service_BookService::get_list_books();

		$this->template->title =
			'Manage Books';

		$this->template->content =
			View::forge(
				'admin/books/index',
				$data
			);
	}

	/*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

	public function action_create()
	{

		$data['authors'] =
			Service_AuthorService::get_list_authors();

		$data['categories'] =
			Service_CategoryService::get_list_categories();

		if (Input::method() == 'POST') {

			try {

				Service_BookService::create_book(

					Input::post('title'),

					Input::post('isbn'),

					Input::post('image'),

					Input::post('author_id'),

					Input::post('category_id'),

					Input::post('total_copies'),

					Input::post('available_copies')
				);

				Session::set_flash(

					'success',

					'Book created successfully.'
				);

				Response::redirect(
					'admin/books'
				);
			} catch (Exception $e) {

				Session::set_flash(

					'error',

					$e->getMessage()
				);
			}
		}

		$this->template->title =
			'Create Book';

		$this->template->content =
			View::forge(
				'admin/books/create',
				$data
			);
	}

	/*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

	public function action_edit($id = null)
	{

		$book =
			Service_BookService::get_book($id);

		if (!$book) {
			throw new HttpNotFoundException;
		}

		$data['book'] = $book;

		$data['authors'] =
			Service_AuthorService::get_list_authors();

		$data['categories'] =
			Service_CategoryService::get_list_categories();

		if (Input::method() == 'POST') {

			try {

				Service_BookService::update_book(

					$id,

					Input::post('title'),

					Input::post('isbn'),

					Input::post('image'),

					Input::post('author_id'),

					Input::post('category_id'),

					Input::post('total_copies'),

					Input::post('available_copies')
				);

				Session::set_flash(

					'success',

					'Book updated successfully.'
				);

				Response::redirect(
					'admin/books'
				);
			} catch (Exception $e) {

				Session::set_flash(

					'error',

					$e->getMessage()
				);
			}
		}

		$this->template->title =
			'Edit Book';

		$this->template->content =
			View::forge(
				'admin/books/edit',
				$data
			);
	}

	/*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

	public function action_delete($id = null)
	{

		try {

			Service_BookService::delete_book($id);

			Session::set_flash(

				'success',

				'Book deleted successfully.'
			);
		} catch (Exception $e) {

			Session::set_flash(

				'error',

				$e->getMessage()
			);
		}

		Response::redirect(
			'admin/books'
		);
	}
}
