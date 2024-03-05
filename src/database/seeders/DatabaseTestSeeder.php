<?php

namespace Database\Seeders;

use Database\Seeders\Student\StudentSeeder;
use Database\Seeders\Testing\QuestionTestSeeder;
use Database\Seeders\Testing\QuizTestSeeder;
use Illuminate\Database\Seeder;

class DatabaseTestSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            QuestionTestSeeder::class,
            StudentSeeder::class,
            QuizTestSeeder::class,
        ]);
    }
}
