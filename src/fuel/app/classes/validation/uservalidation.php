<?php 
namespace Validation;

class UserValidation
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add('username', 'Username')->add_rule('required')->add_rule('min_length', 3);
        $val->add('password', 'Password')->add_rule('required')->add_rule('min_length', 6);
        $val->add('email', 'Email')->add_rule('required')->add_rule('valid_email');
        return $val;
    }
}