<?php

use Fuel\Core\Input;
use Fuel\Core\Pagination;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_User_Books extends Controller_User
{
    const PER_PAGE    = 8;
    const SLIDER_LIMIT = 12;

    /**
     * DANH SÁCH SÁCH
     */
    public function action_index()
    {
        $keyword   = trim(Input::get('keyword', ''));
        $search_by = Input::get('search_by', 'title');

        $pagination = $this->build_pagination(
            $keyword,
            $search_by
        );

        $data = [
            'books'         => $this->get_books(
                $keyword,
                $search_by,
                $pagination
            ),
            'science_books' => $this->get_slider_books('Khoa học'),
            'fiction_books' => $this->get_slider_books('Tiểu thuyết'),
            'keyword'       => $keyword,
            'search_by'     => $search_by,
        ];

        $view = View::forge(
            'user/books/index',
            $data
        );

        $view->set_safe(
            'pagination',
            $pagination->render()
        );

        $this->template->title   = 'Library Catalog';
        $this->template->content = $view;
    }

    /**
     * CHI TIẾT SÁCH
     */
    public function action_view($id = null)
    {
        $book = Service_BookService::get_book($id);

        if (!$book) {

            Session::set_flash(
                'error',
                'Book not found.'
            );

            return Response::redirect(
                'user/books'
            );
        }

        $this->template->title = $book->title;

        $this->template->content = View::forge(
            'user/books/view',
            [
                'book' => $book
            ]
        );
    }

    /**
     * PAGINATION
     */
    protected function build_pagination($keyword, $search_by)
    {
        $total_items = Service_BookService::count_search_results(
            $keyword,
            $search_by
        );

        return Pagination::forge(
            'user_books_pagination',
            [
                'pagination_url' => Uri::create(
                    'user/books/index'
                ),

                'total_items' => $total_items,

                'per_page' => self::PER_PAGE,

                'uri_segment' => 4,

                'link_offset' => '?' . http_build_query([
                    'keyword'   => $keyword,
                    'search_by' => $search_by
                ]),

                'wrapper' => '<div class="pagination">{pagination}</div>',

                'active' => '<span class="active">{link}</span>',

                'regular' => '<span>{link}</span>',

                'previous' => '<span>{link}</span>',

                'next' => '<span>{link}</span>',

                'previous-inactive' => '
                    <span class="previous-inactive">
                        {link}
                    </span>
                ',

                'next-inactive' => '
                    <span class="next-inactive">
                        {link}
                    </span>
                ',
            ]
        );
    }

    /**
     * LẤY DANH SÁCH SÁCH
     */
    protected function get_books($keyword,$search_by,$pagination) {
        return Service_BookService::search_books(
            $keyword,
            $search_by,
            $pagination->per_page,
            $pagination->offset
        );
    }

    /**
     * LẤY SÁCH SLIDER
     */
    protected function get_slider_books($category)
    {
        return Service_BookService::get_books_by_category(
            $category,
            self::SLIDER_LIMIT
        );
    }
}