<?php

class Service_BookService
{
    /**
     * Xóa cache liên quan đến sách
     */
    protected static function clear_cache()
    {
        try {
            Cache::delete_all(CacheKeys::BOOKS_BY_CATEGORY);
            Cache::delete(CacheKeys::BOOKS_ALL);
        } catch (Exception $e) {
            // Cache không tồn tại, không cần xử lý
        }
    }
    public static function get_books_by_category($category_name, $limit = 12)
    {
        $category_slug = Inflector::friendly_title($category_name, '_', true);
        $cache_key = CacheKeys::BOOKS_BY_CATEGORY . $category_slug . '.limit.' . $limit;

        try {
            return Cache::call(
                $cache_key,
                function () use ($category_name, $limit) {
                    return Model_Book::query()
                        ->related('category')
                        ->where('category.category_name', 'LIKE', '%' . $category_name . '%')
                        ->order_by('created_at', 'desc')
                        ->rows_limit($limit)
                        ->get();
                },
                array(), 
                3600
            );
        } catch (\Exception $e) {
            return [];
        }
    }
    /**
     * Tạo sách mới
     */
    public static function create_book(array $data, $image)
    {
        $book = Model_Book::forge();

        // Sử dụng set() để gán hàng loạt dữ liệu từ Input::post()
        $book->set([
            'title'            => Arr::get($data, 'title'),
            'isbn'             => Arr::get($data, 'isbn'),
            'description'      => Arr::get($data, 'description'),
            'author_id'        => Arr::get($data, 'author_id'),
            'category_id'      => Arr::get($data, 'category_id'),
            'total_copies'     => Arr::get($data, 'total_copies'),
            'available_copies' => Arr::get($data, 'available_copies'),
            'image'            => $image,
        ]);

        if ($book->save()) {
            self::clear_cache();
            return $book;
        }
        throw new Exception("Could not save book.");
    }

    /**
     * Cập nhật sách
     */
    public static function update_book($id, array $data, $image)
    {
        $book = Model_Book::find($id);
        if (!$book) throw new Exception('Book not found.');

        $book->set([
            'title'            => Arr::get($data, 'title'),
            'isbn'             => Arr::get($data, 'isbn'),
            'description'      => Arr::get($data, 'description'),
            'author_id'        => Arr::get($data, 'author_id'),
            'category_id'      => Arr::get($data, 'category_id'),
            'total_copies'     => Arr::get($data, 'total_copies'),
            'available_copies' => Arr::get($data, 'available_copies'),
            'image'            => $image,
        ]);

        if ($book->save()) {
            self::clear_cache();
            return $book;
        }
        throw new Exception("Could not update book.");
    }

    /**
     * Xóa sách
     */
    public static function delete_book($id)
    {
        $book = Model_Book::find($id);
        if ($book && $book->delete()) {
            self::clear_cache();
            return true;
        }
        throw new Exception("Delete failed.");
    }

    /**
     * Lấy chi tiết sách
     */
    public static function get_book($id)
    {
        return Model_Book::find($id, ['related' => ['author', 'category']]);
    }

    /**
     * Tìm kiếm và Phân trang
     */
    public static function search_books($keyword = null, $search_by = 'title', $limit = null, $offset = null)
    {
        $query = self::_build_search_query($keyword, $search_by);

        $query->order_by('id', 'desc');

        if ($limit !== null) $query->rows_limit($limit);
        if ($offset !== null) $query->rows_offset($offset);

        $books = $query->get();

        // Format lại dữ liệu trước khi trả về
        return array_map([__CLASS__, '_format_book_output'], $books);
    }

    /**
     * Đếm tổng số bản ghi (Phục vụ phân trang ở Controller)
     */
    public static function count_search_results($keyword = null, $search_by = 'title')
    {
        return self::_build_search_query($keyword, $search_by)->count();
    }

    /**
     * Private Helper: Xây dựng query tìm kiếm dùng chung
     */
    private static function _build_search_query($keyword, $search_by)
    {
        $query = Model_Book::query()->related(['author', 'category']);

        if (!empty($keyword)) {
            $field = 'title'; // Mặc định
            switch ($search_by) {
                case 'isbn':
                    $field = 'isbn';
                    break;
                case 'author':
                    $field = 'author.name';
                    break;
                case 'category':
                    $field = 'category.category_name';
                    break;
            }
            $query->where($field, 'like', "%$keyword%");
        }

        return $query;
    }

    /**
     * Private Helper: Format dữ liệu đầu ra cho View
     */
    private static function _format_book_output($book)
    {
        $desc = $book->description ?: 'No description';
        return [
            'id'                => $book->id,
            'title'             => $book->title,
            'isbn'              => $book->isbn,
            'image'             => $book->image,
            'description'       => $desc,
            'short_description' => Str::truncate($desc, 50), // Dùng helper của FuelPHP
            'available_copies'  => $book->available_copies,
            'total_copies'      => $book->total_copies,
            'author'            => $book->author,
            'category'          => $book->category,
        ];
    }
}
