<?php

namespace Fuel\Tasks;

class Setup
{
    public function run()
    {
        echo "=== CREATE ADMIN ===\n";

        if (!\Auth\Model\Auth_User::find_by_username('admin'))
        {
            \Auth::create_user(
                'admin',
                '123456',
                'admin@gmail.com',
                100
            );

            echo "Admin created\n";
        }
        else
        {
            echo "Admin already exists\n";
        }

        echo "=== CREATE AUTHORS ===\n";

        \Model_Author::forge([
            'name' => 'Nguyen Nhat Anh',
            'biography' => 'Vietnamese author'
        ])->save();

        \Model_Author::forge([
            'name' => 'Haruki Murakami',
            'biography' => 'Japanese author'
        ])->save();

        echo "=== CREATE CATEGORIES ===\n";

        \Model_Category::forge([
            'category_name' => 'Novel'
        ])->save();

        \Model_Category::forge([
            'category_name' => 'Science'
        ])->save();

        echo "=== CREATE BOOKS ===\n";

        \Model_Book::forge([
            'title' => 'Kafka on the Shore',
            'isbn' => '123456789',
            'author_id' => 2,
            'category_id' => 1,
            'total_copies' => 10,
            'available_copies' => 10,
        ])->save();

        echo "DONE\n";
    }
}