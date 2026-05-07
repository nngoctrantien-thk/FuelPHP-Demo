<?php

class Service_BookService
{
    /*
    |--------------------------------------------------------------------------
    | CREATE BOOK
    |--------------------------------------------------------------------------
    */

    public static function create_book(
        $title,
        $isbn,
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

                'category_id' => $category_id,

                'total_copies' => $total_copies,

                'available_copies' => $available_copies,
            ));

            $book->save();

            DB::commit_transaction();

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

            $book->image = $image;

            $book->author_id = $author_id;

            $book->category_id = $category_id;

            $book->total_copies = $total_copies;

            $book->available_copies = $available_copies;

            $book->save();

            DB::commit_transaction();

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

    public static function get_list_books()
    {

        return Model_Book::find('all', array(

            'related' => array(
                'author',
                'category',
            ),

            'order_by' => array(
                'id' => 'desc'
            )
        ));
    }
}