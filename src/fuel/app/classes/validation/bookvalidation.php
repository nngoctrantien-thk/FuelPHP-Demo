<?php

namespace Validation;

class BookValidation
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add('title', 'Title')
            ->add_rule('required')
            ->add_rule('max_length', 255);
        $val->add('isbn', 'ISBN')
            ->add_rule('required')
            ->add_rule('max_length', 20);
        if (empty($_FILES['image']['name'])) {
            $val->error('image', 'Image is required.');
        }
        $val->add('author_id', 'Author')
            ->add_rule('required')
            ->add_rule('valid_string', array('numeric'));
        $val->add('category_id', 'Category')
            ->add_rule('required')
            ->add_rule('valid_string', array('numeric'));
        $val->add('total_copies', 'Total Copies')
            ->add_rule('required')
            ->add_rule('numeric_min', 0);
        $val->add('available_copies', 'Available Copies')
            ->add_rule('required')
            ->add_rule('numeric_min', 0);
        return $val;
    }
}