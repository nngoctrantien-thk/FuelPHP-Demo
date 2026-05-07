<?php

use Orm\Model;

class Model_Book extends Model
{
    protected static $_properties = array(

        'id',

        'title',

        'isbn',

        'image',

        'author_id',

        'category_id',

        'total_copies',

        'available_copies',

        'created_at',

        'updated_at',
    );

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    protected static $_belongs_to = array(

        'author' => array(

            'model_to' => 'Model_Author',

            'key_from' => 'author_id',

            'key_to' => 'id',

            'cascade_save' => false,

            'cascade_delete' => false,
        ),

        'category' => array(

            'model_to' => 'Model_Category',

            'key_from' => 'category_id',

            'key_to' => 'id',

            'cascade_save' => false,

            'cascade_delete' => false,
        ),
    );

    /*
    |--------------------------------------------------------------------------
    | OBSERVER
    |--------------------------------------------------------------------------
    */

    protected static $_observers = array(

        'Orm\Observer_CreatedAt' => array(

            'events' => array(
                'before_insert'
            ),

            'mysql_timestamp' => false,
        ),

        'Orm\Observer_UpdatedAt' => array(

            'events' => array(
                'before_save'
            ),

            'mysql_timestamp' => false,
        ),
    );

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    public static function validate($factory)
    {
        $val = Validation::forge($factory);

        $val->add_field(
            'title',
            'Title',
            'required|max_length[255]'
        );

        $val->add_field(
            'isbn',
            'ISBN',
            'required|max_length[255]'
        );

        $val->add_field(
            'image',
            'Image',
            'max_length[255]'
        );

        $val->add_field(
            'author_id',
            'Author',
            'required|valid_string[numeric]'
        );

        $val->add_field(
            'category_id',
            'Category',
            'required|valid_string[numeric]'
        );

        $val->add_field(
            'total_copies',
            'Total Copies',
            'required|valid_string[numeric]'
        );

        $val->add_field(
            'available_copies',
            'Available Copies',
            'required|valid_string[numeric]'
        );

        return $val;
    }
}