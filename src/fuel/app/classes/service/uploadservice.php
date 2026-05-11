<?php

class Service_UploadService
{
    /*
    |--------------------------------------------------------------------------
    | UPLOAD IMAGE
    |--------------------------------------------------------------------------
    */

    public static function upload_image()
    {
        if (empty($_FILES['image']['name'])) {

            return null;
        }

        \Upload::process(array(

            'path' => DOCROOT . 'assets/img/books/',

            'randomize' => true,

            'ext_whitelist' => array(
                'jpg',
                'jpeg',
                'png',
                'webp'
            ),

            'max_size' => 1024 * 1024 * 2,
        ));

        if (\Upload::is_valid()) {

            \Upload::save();

            $file = \Upload::get_files(0);

            return $file['saved_as'];
        }

        $errors = \Upload::get_errors();

        if (!empty($errors)) {

            throw new Exception(
                $errors[0]['errors'][0]['message']
            );
        }

        throw new Exception(
            'Upload image failed.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE IMAGE
    |--------------------------------------------------------------------------
    */

    public static function delete_image($image = null)
    {
        if (empty($image)) {

            return;
        }

        $image_path =
            DOCROOT .
            'assets/img/books/' .
            $image;

        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}