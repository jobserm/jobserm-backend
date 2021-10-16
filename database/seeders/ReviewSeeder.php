<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $users  = User::get();
//        foreach ($users as $user) {
//            Review::factory(10)->create([
//                'users_id' => $user->id()
//            ]);
//        }
        Review::factory(10)->create();

    }
}
