<?php

use Fuel\Core\Pagination;

class Controller_User_Books extends Controller_User
{
    const PER_PAGE = 8;
    const SLIDER_LIMIT = 12;

    /**
     * Danh sách sách cho User + Tìm kiếm + Phân trang
     */
    public function action_index()
    {
        $keyword   = trim(Input::get('keyword', ''));
        $search_by = Input::get('search_by', 'title');

        // 1. Logic phân trang và tìm kiếm chính
        $total_items = Service_BookService::count_search_results($keyword, $search_by);

        $config = [
            'pagination_url'    => Uri::create('user/books/index'),
            'total_items'       => $total_items,
            'per_page'          => self::PER_PAGE,
            'uri_segment'       => 4,
            'link_offset'       => '?' . http_build_query(['keyword' => $keyword, 'search_by' => $search_by]),
            'wrapper'           => '<div class="pagination">{pagination}</div>',
            'active'            => '<span class="active">{link}</span>',
            'regular'           => '<span>{link}</span>',
            'previous'          => '<span>{link}</span>',
            'next'              => '<span>{link}</span>',
            'previous-inactive' => '<span class="previous-inactive">{link}</span>',
            'next-inactive'     => '<span class="next-inactive">{link}</span>',
        ];

        $pagination = Pagination::forge('user_books_pagination', $config);

        // 2. Lấy dữ liệu sách cho danh sách chính
        $books = Service_BookService::search_books($keyword, $search_by, $pagination->per_page, $pagination->offset);

        // 3. Lấy dữ liệu cho 2 Slider Category
        $science_books = Service_BookService::get_books_by_category('Khoa học', self::SLIDER_LIMIT);
        $fiction_books = Service_BookService::get_books_by_category('Tiểu thuyết', self::SLIDER_LIMIT);

        $data = [
            'books'         => $books,
            'science_books' => $science_books,
            'fiction_books' => $fiction_books,
            'keyword'       => $keyword,
            'search_by'     => $search_by,
        ];
        $view = View::forge('user/books/index', $data);
        $view->set_safe('pagination', $pagination->render());

        $this->template->title = 'Library Catalog';
        $this->template->content = $view;
    }
    /**
     * Xem chi tiết sách
     */
    public function action_view($id = null)
    {
        $book = Service_BookService::get_book($id);

        if (!$book) {
            Session::set_flash('error', 'Book not found.');
            Response::redirect('user/books');
        }

        $data['book'] = $book;
        $this->template->title = $book->title;
        $this->template->content = View::forge('user/books/view', $data);
    }
}
