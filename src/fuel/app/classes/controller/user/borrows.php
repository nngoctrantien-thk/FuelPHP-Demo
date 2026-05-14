<?php

class Controller_User_Borrows extends Controller_User
{
    /**
     * Helper lấy ID người dùng hiện tại
     */
    private function _user_id()
    {
        return Auth::get_user_id()[1];
    }

    /**
     * Danh sách sách đang mượn + Gợi ý sách cùng tác giả
     */
    public function action_index()
    {
        $user_id = $this->_user_id();

        // Sử dụng Service để lấy toàn bộ dữ liệu cần thiết cho trang Index
        $borrows         = Service_BorrowService::get_active_borrows($user_id);
        $suggested_books = Service_BorrowService::get_suggestions_by_borrowed_authors($user_id);

        $this->template->title = 'My Borrowed Books';
        $this->template->content = View::forge('user/borrows/index', [
            'borrows'         => $borrows,
            'suggested_books' => $suggested_books
        ]);
    }

    /**
     * Thực hiện mượn sách
     */
    public function action_create($book_id = null)
    {
        if (!$book_id) {
            Session::set_flash('error', 'Invalid book ID.');
            return Response::redirect('user/books');
        }

        try {
            Service_BorrowService::borrow_book($this->_user_id(), $book_id);
            Session::set_flash('success', 'Book borrowed successfully!');
        } catch (Exception $e) {
            Session::set_flash('error', $e->getMessage());
        }

        // Chuyển hướng về trang danh sách đang mượn
        return Response::redirect('user/borrowed');
    }

    /**
     * Thực hiện trả sách
     */
    public function action_return($borrow_id = null)
    {
        if (!$borrow_id) {
            Session::set_flash('error', 'Invalid borrow record.');
            return Response::redirect('user/borrowed');
        }

        try {
            Service_BorrowService::return_book($borrow_id, $this->_user_id());
            Session::set_flash('success', 'Book returned successfully.');
        } catch (Exception $e) {
            Session::set_flash('error', $e->getMessage());
        }

        return Response::redirect('user/borrowed');
    }
}