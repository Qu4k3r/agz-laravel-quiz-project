<?php

namespace Database\Seeders;

use Database\Seeders\Quiz\Question\QuestionSeeder;
use Database\Seeders\Quiz\Subject\SubjectSeeder;
use Database\Seeders\Student\StudentSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            SubjectSeeder::class,
            QuestionSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
