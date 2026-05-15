<?php

class Service_BookService
{
    protected static function clear_cache()
    {
        try {
            Cache::delete_all(CacheKeys::BOOKS_BY_CATEGORY);
            Cache::delete(CacheKeys::BOOKS_ALL);
        } catch (Exception $e) {
        }
    }

    public static function get_books_by_category($category_name, $limit)
    {
        $category_slug = Inflector::friendly_title($category_name, '_', true);
        $cache_key = CacheKeys::BOOKS_BY_CATEGORY . $category_slug . '.limit.' . $limit;

        try {
            return Cache::call($cache_key, function () use ($category_name, $limit) {
                return Model_Book::query()
                    ->related('category')
                    ->where('category.category_name', 'LIKE', '%' . $category_name . '%')
                    ->order_by('created_at', 'desc')
                    ->rows_limit($limit)
                    ->get();
            }, [], 3600);
        } catch (Exception $e) {
            return [];
        }
    }

    public static function create_book(array $data, $image)
    {
        DB::start_transaction();
        try {
            $book = Model_Book::forge();
            self::_populate_book_data($book, $data, $image);
            
            if ($book->save()) {
                DB::commit_transaction();
                self::clear_cache();
                return $book;
            }
            throw new Exception("Could not save book.");
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    public static function update_book($id, array $data, $image)
    {
        $book = Model_Book::find($id);
        if (!$book) {
            throw new Exception('Book not found.');
        }

        DB::start_transaction();
        try {
            self::_populate_book_data($book, $data, $image);
            
            if ($book->save()) {
                DB::commit_transaction();
                self::clear_cache();
                return $book;
            }
            throw new Exception("Could not update book.");
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    public static function delete_book($id)
    {
        $book = Model_Book::find($id);
        if (!$book) {
            throw new Exception('Book not found.');
        }

        DB::start_transaction();
        try {
            if ($book->delete()) {
                DB::commit_transaction();
                self::clear_cache();
                return true;
            }
            throw new Exception("Delete failed.");
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    public static function get_book($id)
    {
        return Model_Book::find($id, ['related' => ['author', 'category']]);
    }

    public static function search_books($keyword, $search_by = 'title', $limit, $offset)
    {
        $query = self::_build_search_query($keyword, $search_by);
        $query->order_by('id', 'desc');

        if ($limit !== null) $query->rows_limit($limit);
        if ($offset !== null) $query->rows_offset($offset);

        return array_map([__CLASS__, '_format_book_output'], $query->get());
    }

    public static function count_search_results($keyword, $search_by = 'title')
    {
        return self::_build_search_query($keyword, $search_by)->count();
    }

    private static function _build_search_query($keyword, $search_by)
    {
        $query = Model_Book::query()->related(['author', 'category']);

        if (!empty($keyword)) {
            $fields = [
                'isbn'     => 'isbn',
                'author'   => 'author.name',
                'category' => 'category.category_name'
            ];
            $field = $fields[$search_by] ?? 'title';
            $query->where($field, 'like', "%$keyword%");
        }

        return $query;
    }

    private static function _format_book_output($book)
    {
        $desc = $book->description ?: 'No description';
        return [
            'id'                => $book->id,
            'title'             => $book->title,
            'isbn'              => $book->isbn,
            'image'             => $book->image,
            'description'       => $desc,
            'short_description' => Str::truncate($desc, 50),
            'available_copies'  => $book->available_copies,
            'total_copies'      => $book->total_copies,
            'author'            => $book->author,
            'category'          => $book->category,
        ];
    }

    private static function _populate_book_data(&$book, array $data, $image)
    {
        $fillable = ['title', 'isbn', 'description', 'author_id', 'category_id', 'total_copies', 'available_copies'];
        
        foreach ($fillable as $field) {
            if (isset($data[$field])) {
                $book->{$field} = $data[$field];
            }
        }

        if ($image !== null) {
            $book->image = $image;
        }
    }
}