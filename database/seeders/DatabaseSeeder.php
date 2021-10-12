<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Job;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CategorySeeder::class);
        $this->call(JobSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(UserSeeder::class);
    }
}
