<?php

namespace Database\Seeders;

use Database\Seeders\Testing\QuestionTestSeeder;
use Illuminate\Database\Seeder;

class DatabaseTestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            QuestionTestSeeder::class,
        ]);
    }
}
