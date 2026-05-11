<?php

class Controller_Admin_Books extends Controller_Admin
{
	public function action_view($id = null)
	{
		$book = Service_BookService::get_book($id);
		if (!$book) {
			throw new HttpNotFoundException;
		}
		$data['book'] = $book;
		$this->template->title =
			'View Book';
		$this->template->content =
			View::forge(
				'admin/books/view',
				$data
			);
	}
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

		/*
        |--------------------------------------------------------------------------
        | VALIDATION ERRORS
        |--------------------------------------------------------------------------
        */

		$data['errors'] = array();

		if (Input::method() == 'POST') {

			$val = \Validation\BookValidation::validate();

			if ($val->run()) {

				try {
					$image = Service_UploadService::upload_image();
					if (!$image) {
						throw new Exception(
							'Upload image failed.'
						);
					}
					Service_BookService::create_book(

						Input::post('title'),

						Input::post('isbn'),

						$image,

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
			} else {

				/*
                |--------------------------------------------------------------------------
                | FIELD ERRORS
                |--------------------------------------------------------------------------
                */

				$data['errors'] = $val->error();

				/*
                |--------------------------------------------------------------------------
                | FLASH ERRORS
                |--------------------------------------------------------------------------
                */

				$messages = array();

				foreach ($val->error() as $error) {

					$messages[] = $error->get_message();
				}

				Session::set_flash(
					'errors',
					$messages
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
		$book = Service_BookService::get_book($id);
		if (!$book) {
			throw new HttpNotFoundException;
		}
		$data['book'] = $book;
		$data['authors'] = Service_AuthorService::get_list_authors();

		$data['categories'] = Service_CategoryService::get_list_categories();
		$data['errors'] = array();
		if (Input::method() == 'POST') {
			$val = \Validation\BookValidation::validate();
			if ($val->run()) {
				try {
					DB::start_transaction();
					$image = $book->image;
					$new_image = null;
					if (!empty($_FILES['image']['name'])) {
						$new_image = Service_UploadService::upload_image();
						$image = $new_image;
					}
					Service_BookService::update_book(
						$id,
						Input::post('title'),
						Input::post('isbn'),
						$image,
						Input::post('author_id'),
						Input::post('category_id'),
						Input::post('total_copies'),
						Input::post('available_copies')
					);
					DB::commit_transaction();
					if ($new_image && $book->image) {
						Service_UploadService::delete_image(
							$book->image
						);
					}
					Session::set_flash(
						'success',
						'Book updated successfully.'
					);
					Response::redirect(
						'admin/books'
					);
				} catch (Exception $e) {
					DB::rollback_transaction();
					if (!empty($new_image)) {
						Service_UploadService::delete_image(
							$new_image
						);
					}
					Session::set_flash(
						'error',
						$e->getMessage()
					);
				}
			} else {

				$data['errors'] = $val->error();

				$messages = array();

				foreach ($val->error() as $error) {

					$messages[] = $error->get_message();
				}

				Session::set_flash(
					'errors',
					$messages
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
		$book = Service_BookService::get_book($id);

		if (!$book) {

			throw new HttpNotFoundException;
		}

		if (Input::method() == 'POST') {

			try {

				DB::start_transaction();

				Service_BookService::delete_book($id);

				DB::commit_transaction();

				Service_UploadService::delete_image(
					$book->image
				);

				Session::set_flash(
					'success',
					'Book deleted successfully.'
				);

				Response::redirect(
					'admin/books'
				);
			} catch (Exception $e) {

				DB::rollback_transaction();

				Session::set_flash(
					'error',
					$e->getMessage()
				);
			}
		}

		$data['book'] = $book;
		$this->template->title =
			'Delete Book';
		$this->template->content =
			View::forge(
				'admin/books/delete',
				$data
			);
	}
}
