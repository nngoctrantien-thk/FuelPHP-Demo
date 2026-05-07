<?php

namespace Fuel\Tasks;

class Seed_Post
{
    public static function run()
    {
        echo "Start seeding posts ...\n";

        \DB::delete('posts')->execute();

        for ($i = 1; $i <= 10; $i++)
        {
            \Model_Post::forge([
                'title' => 'Title '.$i,
                'body' => 'Body '.$i,
                'user_id' => rand(1, 5),
            ])->save();
        }

        echo "Seeding posts done.\n";
        
    }
}