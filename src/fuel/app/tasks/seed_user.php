<?php
namespace Fuel\Tasks;

class Seed_User
{
    public function run()
    {
        echo "Đang tạo dữ liệu mẫu...\n";

        try {
            // Tạo user admin
            \Auth::create_user('admin', '123456', 'admin@example.com');
            echo "--- Đã tạo user: admin / 123456\n";
        } catch (\Exception $e) {
            echo "--- Lỗi: " . $e->getMessage() . "\n";
        }
    }
}