<?php

namespace Fuel\Tasks;

class Setup
{
    public function run()
    {
        echo "=== CREATE ADMIN ===\n";

        // Sử dụng Model_User bạn vừa tạo để kiểm tra cho đồng bộ
        if (!\Model_User::find_by_username('admin'))
        {
            \Auth::create_user(
                'admin',
                '123456',
                'admin@gmail.com',
                100, // Group Admin
                array(
                    'is_active' => 1,         // Kích hoạt luôn cho Admin
                    'activation_token' => null // Không cần token
                )
            );

            echo "Admin created and activated successfully.\n";
        }
        else
        {
            echo "Admin already exists\n";
        }

        echo "=== CREATE AUTHORS ===\n";

        if (!\Model_Author::find_by_name('Nguyen Nhat Anh')) {
            \Model_Author::forge([
                'name' => 'Nguyen Nhat Anh',
                'biography' => 'Vietnamese author'
            ])->save();
        }

        if (!\Model_Author::find_by_name('Haruki Murakami')) {
            \Model_Author::forge([
                'name' => 'Haruki Murakami',
                'biography' => 'Japanese author'
            ])->save();
        }

        echo "=== CREATE CATEGORIES ===\n";

        if (!\Model_Category::find_by_category_name('Tiểu thuyết')) {
            \Model_Category::forge([
                'category_name' => 'Tiểu thuyết'
            ])->save();
        }

        if (!\Model_Category::find_by_category_name('Khoa học')) {
            \Model_Category::forge([
                'category_name' => 'Khoa học'
            ])->save();
        }

        echo "=== CREATE BOOKS ===\n";

        if (!\Model_Book::find_by_title('Kafka on the Shore')) {
            \Model_Book::forge([
                'title' => 'Kafka on the Shore',
                'isbn' => '123456789',
                'image' => 'item-image8.jpg',
                'author_id' => 2,
                'category_id' => 1,
                'total_copies' => 10,
                'available_copies' => 10,
                'status' => 'Available'
            ])->save();
        }

        echo "DONE\n";
    }
}