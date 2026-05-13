<?php

use Fuel\Core\Pagination;

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
		$keyword = trim(Input::get('keyword'));

		$search_by = Input::get('search_by', 'title');



		$count_query = Model_Book::query()

			->related('author')

			->related('category');

		if (!empty($keyword)) {

			switch ($search_by) {

				case 'isbn':

					$count_query->where(
						'isbn',
						'like',
						'%' . $keyword . '%'
					);

					break;

				case 'author':

					$count_query->where(
						'author.name',
						'like',
						'%' . $keyword . '%'
					);

					break;

				case 'category':

					$count_query->where(
						'category.category_name',
						'like',
						'%' . $keyword . '%'
					);

					break;

				default:

					$count_query->where(
						'title',
						'like',
						'%' . $keyword . '%'
					);

					break;
			}
		}



		$config = array(

			'pagination_url' =>
			'/admin/books/index?keyword='
				. urlencode($keyword)
				. '&search_by='
				. $search_by,

			'total_items' => $count_query->count(),

			'per_page' => 5,

			'uri_segment' => 4,
		);

		$pagination = Pagination::forge(
			'books_pagination',
			$config
		);



		$data['books'] = Service_BookService::search_books(

			$keyword,

			$search_by,

			$pagination->per_page,

			$pagination->offset

		);

		$data['pagination'] = $pagination->render();



		$this->template->title = 'Manage Books';

		$this->template->content = View::forge(
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

						Input::post('description'),

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
						Input::post('description'),
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
