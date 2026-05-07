<?php

class Service_CategoryService
{
    /*
    |--------------------------------------------------------------------------
    | CREATE CATEGORY
    |--------------------------------------------------------------------------
    */

    public static function create_category(
        $category_name
    ) {

        DB::start_transaction();

        try {

            $category = Model_Category::forge(array(

                'category_name' => $category_name,
            ));

            $category->save();

            DB::commit_transaction();

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

        DB::start_transaction();

        try {

            $category->category_name =
                $category_name;

            $category->save();

            DB::commit_transaction();

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

        $book_exists = Model_Book::find('first', array(

            'where' => array(
                array('category_id', $category_id)
            )
        ));

        if ($book_exists) {

            throw new Exception(
                'Cannot delete category because books exist.'
            );
        }

        DB::start_transaction();

        try {

            $category->delete();

            DB::commit_transaction();

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

        return Model_Category::find('all', array(

            'order_by' => array(
                'id' => 'desc'
            )
        ));
    }
}