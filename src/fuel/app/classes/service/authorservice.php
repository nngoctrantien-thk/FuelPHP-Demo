<?php

class Service_AuthorService
{
    /*
    |--------------------------------------------------------------------------
    | CLEAR CACHE
    |--------------------------------------------------------------------------
    */
    public static function clear_cache()
    {
        try {
            Cache::delete(
                CacheKeys::AUTHORS_ALL
            );
        } catch (Exception $e) {
        }
    }
    public static function create_author(
        $name,
        $biography = null
    ) {
        DB::start_transaction();
        try {
            $author = Model_Author::forge(array(
                'name' => $name,
                'biography' => $biography,
            ));
            $author->save();
            DB::commit_transaction();
            self::clear_cache();
            return $author;
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }
    /*
    |--------------------------------------------------------------------------
    | UPDATE AUTHOR
    |--------------------------------------------------------------------------
    */

    public static function update_author(
        $author_id,
        $name,
        $biography = null
    ) {
        $author = Model_Author::find($author_id);
        if (!$author) {
            throw new Exception(
                'Author not found.'
            );
        }
        DB::start_transaction();
        try {
            $author->name = $name;
            $author->biography = $biography;
            $author->save();
            DB::commit_transaction();
            self::clear_cache();
            return $author;
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE AUTHOR
    |--------------------------------------------------------------------------
    */

    public static function delete_author($author_id)
    {
        $author = Model_Author::find($author_id);
        if (!$author) {
            throw new Exception(
                'Author not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK BOOK EXISTS
        |--------------------------------------------------------------------------
        */

        $book_exists = Model_Book::find('first', array(
            'where' => array(
                array('author_id', $author_id)
            )
        ));

        if ($book_exists) {

            throw new Exception(
                'Cannot delete author because books exist.'
            );
        }

        DB::start_transaction();
        try {
            $author->delete();
            DB::commit_transaction();
            self::clear_cache();
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET AUTHOR DETAIL
    |--------------------------------------------------------------------------
    */

    public static function get_author($author_id)
    {
        return Model_Author::find($author_id);
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL AUTHORS
    |--------------------------------------------------------------------------
    */

    public static function get_list_authors()
    {
        try {
            return Cache::get(
                CacheKeys::AUTHORS_ALL
            );
        } catch (CacheNotFoundException $e) {
            $authors = Model_Author::find('all', array(
                'order_by' => array(
                    'id' => 'desc'
                )
            ));
            Cache::set(
                CacheKeys::AUTHORS_ALL,
                $authors,
                300
            );
            return $authors;
        }
    }
}
