<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Post;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the admin user
        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin'),
            'date_of_birth' => '2003-01-02',
            'exp' => 58294,
            'coins' => 5829,
            'is_admin' => true,
            'cover_photo' => array_rand(['coverphoto/cPNXMu5NCANZQ0U9ZeUcnhiwVhYpWGMmGvMXr2fj.jpg', 'coverphoto/JLfqAeBbqMWuhDexd3LfXxoJuwqSvOCg8iojtQmT.png', 'coverphoto/OxBMdN2yT4k8ibNKaFWS2XywB260RFwLZWgk80Wf.jpg', 'coverphoto/PucG4R4V0J9rdfrgegaUWHHd7wLP477dBPkNTuzF.jpg', 'coverphoto/xgaVYZgRjZKLJmWZtMe6jZhQxEzNOxYkjMjgD7Pw.jpg', 'none'])
        ]);

        // Create 12 additional users
        User::factory(12)->create();

        // Create posts for each user
        User::all()->each(function ($user) {
            $user->posts()->saveMany(
                Post::factory(2)->create(['user_id' => $user->id])
            );
        });

        // Create 18 items
        Item::factory(18)->create();

        // Insert friendships
        DB::table('friendships')->insert([
            ['user_id_1' => 2, 'user_id_2' => 3, 'status' => "accepted"],
            ['user_id_1' => 3, 'user_id_2' => 4, 'status' => "accepted"],
            ['user_id_1' => 4, 'user_id_2' => 5, 'status' => "accepted"],
            ['user_id_1' => 5, 'user_id_2' => 6, 'status' => "accepted"],
            ['user_id_1' => 2, 'user_id_2' => 6, 'status' => "accepted"],
        ]);
    }
}
