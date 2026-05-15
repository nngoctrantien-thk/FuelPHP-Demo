<?php

class Service_AuthorService
{
    public static function clear_cache()
    {
        try {
            Cache::delete(CacheKeys::AUTHORS_ALL);
        } catch (Exception $e) {
            // Silence cache errors
        }
    }

    public static function create_author($name, $biography)
    {
        DB::start_transaction();
        try {
            $author = Model_Author::forge([
                'name'      => $name,
                'biography' => $biography,
            ]);

            $author->save();
            DB::commit_transaction();
            
            self::clear_cache();
            return $author;
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    public static function update_author($author_id, $name, $biography)
    {
        $author = Model_Author::find($author_id);
        if (!$author) {
            throw new Exception('Author not found.');
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

    public static function delete_author($author_id)
    {
        $author = Model_Author::find($author_id);
        if (!$author) {
            throw new Exception('Author not found.');
        }

        $book_exists = Model_Book::find('first', [
            'where' => [['author_id', $author_id]]
        ]);

        if ($book_exists) {
            throw new Exception('Cannot delete author because books exist.');
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

    public static function get_author($author_id)
    {
        return Model_Author::find($author_id);
    }

    public static function get_list_authors()
    {
        try {
            return Cache::get(CacheKeys::AUTHORS_ALL);
        } catch (CacheNotFoundException $e) {
            $authors = Model_Author::find('all', [
                'order_by' => ['id' => 'desc']
            ]);

            Cache::set(CacheKeys::AUTHORS_ALL, $authors, 300);
            return $authors;
        }
    }
}