<?php

class Service_CategoryService
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
                CacheKeys::CATEGORIES_ALL
            );

        } catch (Exception $e) {

            // ignore cache exception
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE CATEGORY
    |--------------------------------------------------------------------------
    */

    public static function create_category(
        $category_name
    ) {

        $category_name = trim($category_name);

        /*
        |--------------------------------------------------------------------------
        | CHECK DUPLICATE
        |--------------------------------------------------------------------------
        */

        $exists = Model_Category::query()

            ->where('category_name', $category_name)

            ->get_one();

        if ($exists) {

            throw new Exception(
                'Category already exists.'
            );
        }

        DB::start_transaction();

        try {

            $category = Model_Category::forge(array(

                'category_name' => $category_name,
            ));

            $category->save();

            DB::commit_transaction();

            /*
            |--------------------------------------------------------------------------
            | CLEAR CACHE
            |--------------------------------------------------------------------------
            */

            self::clear_cache();

            return $category;

        } catch (Exception $e) {

            DB::rollback_transaction();

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CATEGORY
    |--------------------------------------------------------------------------
    */

    public static function update_category(
        $category_id,
        $category_name
    ) {

        $category = Model_Category::find($category_id);

        if (!$category) {

            throw new Exception(
                'Category not found.'
            );
        }

        $category_name = trim($category_name);

        /*
        |--------------------------------------------------------------------------
        | CHECK DUPLICATE
        |--------------------------------------------------------------------------
        */

        $exists = Model_Category::query()

            ->where('category_name', $category_name)

            ->where('id', '!=', $category_id)

            ->get_one();

        if ($exists) {

            throw new Exception(
                'Category already exists.'
            );
        }

        DB::start_transaction();

        try {

            $category->category_name =
                $category_name;

            $category->save();

            DB::commit_transaction();

            /*
            |--------------------------------------------------------------------------
            | CLEAR CACHE
            |--------------------------------------------------------------------------
            */

            self::clear_cache();

            return $category;

        } catch (Exception $e) {

            DB::rollback_transaction();

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CATEGORY
    |--------------------------------------------------------------------------
    */

    public static function delete_category($category_id)
    {

        $category = Model_Category::find($category_id);

        if (!$category) {

            throw new Exception(
                'Category not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK BOOK EXISTS
        |--------------------------------------------------------------------------
        */

        $book_exists = Model_Book::query()

            ->where('category_id', $category_id)

            ->get_one();

        if ($book_exists) {

            throw new Exception(
                'Cannot delete category because books exist.'
            );
        }

        DB::start_transaction();

        try {

            $category->delete();

            DB::commit_transaction();

            /*
            |--------------------------------------------------------------------------
            | CLEAR CACHE
            |--------------------------------------------------------------------------
            */

            self::clear_cache();

        } catch (Exception $e) {

            DB::rollback_transaction();

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET CATEGORY DETAIL
    |--------------------------------------------------------------------------
    */

    public static function get_category($category_id)
    {

        return Model_Category::find($category_id);
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL CATEGORIES
    |--------------------------------------------------------------------------
    */

    public static function get_list_categories()
    {

        try {

            return Cache::get(
                CacheKeys::CATEGORIES_ALL
            );

        } catch (CacheNotFoundException $e) {

            $categories = Model_Category::find('all', array(

                'order_by' => array(
                    'id' => 'desc'
                )
            ));

            /*
            |--------------------------------------------------------------------------
            | SAVE CACHE
            |--------------------------------------------------------------------------
            */

            Cache::set(

                CacheKeys::CATEGORIES_ALL,

                $categories,

                300
            );

            return $categories;
        }
    }
}