<?php

class Service_BookService
{
    /*
    |--------------------------------------------------------------------------
    | CLEAR CACHE
    |--------------------------------------------------------------------------
    */

    protected static function clear_cache()
    {
        try {
            Cache::delete(
                CacheKeys::BOOKS_ALL
            );
        } catch (Exception $e) {
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE BOOK
    |--------------------------------------------------------------------------
    */

    public static function create_book(
        $title,
        $isbn,
        $description,
        $image,
        $author_id,
        $category_id,
        $total_copies,
        $available_copies
    ) {
        DB::start_transaction();
        try {
            $book = Model_Book::forge(array(
                'title' => $title,
                'isbn' => $isbn,
                'image' => $image,
                'author_id' => $author_id,
                'description' => $description,
                'category_id' => $category_id,
                'total_copies' => $total_copies,
                'available_copies' => $available_copies,
            ));
            $book->save();
            DB::commit_transaction();
            self::clear_cache();
            return $book;
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE BOOK
    |--------------------------------------------------------------------------
    */

    public static function update_book(
        $book_id,
        $title,
        $isbn,
        $description,
        $image,
        $author_id,
        $category_id,
        $total_copies,
        $available_copies
    ) {

        $book = Model_Book::find($book_id);
        if (!$book) {
            throw new Exception(
                'Book not found.'
            );
        }
        DB::start_transaction();
        try {
            $book->title = $title;
            $book->isbn = $isbn;
            $book->description = $description;
            $book->image = $image;
            $book->author_id = $author_id;
            $book->category_id = $category_id;
            $book->total_copies = $total_copies;
            $book->available_copies = $available_copies;
            $book->save();
            DB::commit_transaction();
            self::clear_cache();
            return $book;
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE BOOK
    |--------------------------------------------------------------------------
    */

    public static function delete_book($book_id)
    {
        $book = Model_Book::find($book_id);
        if (!$book) {
            throw new Exception(
                'Book not found.'
            );
        }
        DB::start_transaction();
        try {
            $book->delete();
            DB::commit_transaction();
            self::clear_cache();
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET BOOK DETAIL
    |--------------------------------------------------------------------------
    */

    public static function get_book($book_id)
    {
        return Model_Book::find($book_id, array(
            'related' => array(
                'author',
                'category',
            )
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL BOOKS
    |--------------------------------------------------------------------------
    */

    public static function get_list_books($limit = null, $offset = null)
    {


        $cache_key = CacheKeys::BOOKS_ALL
            . '_' . (int)$limit
            . '_' . (int)$offset;

        try {

            return Cache::get($cache_key);
        } catch (CacheNotFoundException $e) {


            $query = Model_Book::query()

                ->related('author')

                ->related('category')

                ->order_by('id', 'desc');


            if ($limit !== null) {

                $query->rows_limit($limit);
            }

            if ($offset !== null) {

                $query->rows_offset($offset);
            }

            $books = $query->get();


            $result = array();

            foreach ($books as $book) {

                $description = !empty($book->description)
                    ? $book->description
                    : 'No description';

                $short_description = strlen($description) > 50
                    ? substr($description, 0, 50) . '...'
                    : $description;

                $result[] = array(

                    'id' => $book->id,

                    'title' => $book->title,

                    'isbn' => $book->isbn,

                    'image' => $book->image,

                    'description' => $book->description,

                    'short_description' => $short_description,

                    'available_copies' => $book->available_copies,

                    'total_copies' => $book->total_copies,

                    'author' => $book->author,

                    'category' => $book->category,
                );
            }


            Cache::set(
                $cache_key,
                $result,
                300
            );

            return $result;
        }
    }
    public static function search_books(
        $keyword = null,
        $search_by = 'title',
        $limit = null,
        $offset = null
    ) {

        $query = Model_Book::query()

            ->related('author')

            ->related('category')

            ->order_by('id', 'desc');


        if (!empty($keyword)) {

            switch ($search_by) {

                case 'isbn':

                    $query->where(
                        'isbn',
                        'like',
                        '%' . $keyword . '%'
                    );

                    break;

                case 'author':

                    $query->related('author');

                    $query->where(
                        'author.name',
                        'like',
                        '%' . $keyword . '%'
                    );

                    break;

                case 'category':

                    $query->related('category');

                    $query->where(
                        'category.category_name',
                        'like',
                        '%' . $keyword . '%'
                    );

                    break;

                default:

                    $query->where(
                        'title',
                        'like',
                        '%' . $keyword . '%'
                    );

                    break;
            }
        }

        /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

        if ($limit !== null) {

            $query->rows_limit($limit);
        }

        if ($offset !== null) {

            $query->rows_offset($offset);
        }

        $books = $query->get();

        /*
    |--------------------------------------------------------------------------
    | FORMAT
    |--------------------------------------------------------------------------
    */

        $result = array();

        foreach ($books as $book) {

            $description = !empty($book->description)
                ? $book->description
                : 'No description';

            $short_description = strlen($description) > 50
                ? substr($description, 0, 50) . '...'
                : $description;

            $result[] = array(

                'id' => $book->id,

                'title' => $book->title,

                'isbn' => $book->isbn,

                'image' => $book->image,

                'description' => $book->description,

                'short_description' => $short_description,

                'available_copies' => $book->available_copies,

                'total_copies' => $book->total_copies,

                'author' => $book->author,

                'category' => $book->category,
            );
        }

        return $result;
    }
}
