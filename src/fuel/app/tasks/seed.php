<?php

namespace Fuel\Tasks;

class Seed
{
    public static function run()
    {
        echo "Start seeding...\n";

        \DB::delete('admins')->execute();

        for ($i = 1; $i <= 10; $i++)
        {
            \Model_Admin::forge([
                'title' => 'Title '.$i,
                'body' => 'Body '.$i,
                'user_id' => rand(1, 5),
            ])->save();
        }

        echo "Seeding done.\n";
        
    }
}