<?php

use Fuel\Core\Pagination;

class Controller_Admin_Books extends Controller_Admin
{
	// Cấu hình phân trang
	const PER_PAGE = 8;

	/**
	 * Danh sách sách + Tìm kiếm + Phân trang
	 */
	public function action_index()
	{
		$keyword   = trim(Input::get('keyword', ''));
		$search_by = Input::get('search_by', 'title');

		$pagination = Service_PaginationService::forge(
			'books_pagination',
			'admin/books/index',
			Service_BookService::count_search_results(
				$keyword,
				$search_by
			),
			self::PER_PAGE,
			4,
			[
				'keyword'   => $keyword,
				'search_by' => $search_by
			]
		);

		$view = View::forge('admin/books/index', [
			'books' => Service_BookService::search_books(
				$keyword,
				$search_by,
				$pagination->per_page,
				$pagination->offset
			),
		]);

		$view->set_safe(
			'pagination',
			$pagination->render()
		);
		$this->template->title = 'Books Management';
		$this->template->content = $view;
	}

	/**
	 * Xem chi tiết sách
	 */
	public function action_view($id = null)
	{
		$book = $this->_find_book($id);
		$this->template->title = 'View Book';
		$this->template->content = View::forge('admin/books/view', ['book' => $book]);
	}

	/**
	 * Thêm mới sách
	 */
	public function action_create()
	{
		if (Input::method() === 'POST') {
			$val = \Validation\BookValidation::validate();
			if ($val->run()) {
				try {
					$image = Service_UploadService::upload_image();
					if (!$image) throw new Exception('Vui lòng chọn ảnh hợp lệ.');
					Service_BookService::create_book(Input::post(), $image);
					Session::set_flash('success', 'Thêm sách mới thành công.');
					Response::redirect('admin/books');
				} catch (Exception $e) {
					Session::set_flash('error', $e->getMessage());
				}
			} else {
				$this->_handle_validation_errors($val);
			}
		}
		$this->_render_form('Create Book', 'admin/books/create');
	}
	/**
	 * Chỉnh sửa sách
	 */
	public function action_edit($id = null)
	{
		$book = $this->_find_book($id);
		if (Input::method() === 'POST') {
			$val = \Validation\BookValidation::validate();

			if ($val->run()) {
				$new_image = null;
				try {
					DB::start_transaction();
					if (!empty($_FILES['image']['name'])) {
						$new_image = Service_UploadService::upload_image();
					}
					$image_to_save = $new_image ?: $book->image;
					Service_BookService::update_book($id, Input::post(), $image_to_save);
					DB::commit_transaction();
					if ($new_image && $book->image) {
						Service_UploadService::delete_image($book->image);
					}
					Session::set_flash('success', 'Cập nhật sách thành công.');
					Response::redirect('admin/books');
				} catch (Exception $e) {
					DB::rollback_transaction();
					if ($new_image) Service_UploadService::delete_image($new_image);
					Session::set_flash('error', $e->getMessage());
				}
			} else {
				$this->_handle_validation_errors($val);
			}
		}
		$this->_render_form('Edit Book', 'admin/books/edit', ['book' => $book]);
	}
	/**
	 * Xóa sách
	 */
	public function action_delete($id = null)
	{
		$book = $this->_find_book($id);

		if (Input::method() == 'POST') {
			try {
				DB::start_transaction();

				$image_path = $book->image;
				Service_BookService::delete_book($id);

				DB::commit_transaction();

				Service_UploadService::delete_image($image_path);

				Session::set_flash('success', 'Xóa sách thành công.');
				Response::redirect('admin/books');
			} catch (Exception $e) {
				DB::rollback_transaction();
				Session::set_flash('error', $e->getMessage());
			}
		}

		$this->template->title = 'Delete Book';
		$this->template->content = View::forge('admin/books/delete', ['book' => $book]);
	}


	/**
	 * Tìm sách hoặc trả về 404
	 */
	private function _find_book($id)
	{
		$book = Service_BookService::get_book($id);
		if (!$book) throw new HttpNotFoundException;
		return $book;
	}
	
	private function _handle_validation_errors($val)
	{
		$messages = array_map(function ($error) {
    		return $error->get_message();
		}, $val->error());
		Session::set_flash('errors', $messages);
	}

	private function _render_form($title, $view, $extra_data = [])
	{
		$data = array_merge($extra_data, [
			'authors'    => Service_AuthorService::get_list_authors(),
			'categories' => Service_CategoryService::get_list_categories(),
		]);
		$this->template->title = $title;
		$this->template->content = View::forge($view, $data);
	}
}
