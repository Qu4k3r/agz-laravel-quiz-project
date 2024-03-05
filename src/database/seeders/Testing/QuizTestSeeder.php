<?php

namespace Database\Seeders\Testing;

use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use App\Packages\Student\Domain\Model\Student;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class QuizTestSeeder extends Seeder
{
    public function run()
    {
        $this->createQuiz();
    }

    private function createQuiz(): void
    {
        $student = EntityManager::getRepository(Student::class)->findOneBy(['lastname' => 'Neves']);
        $quiz = new Quiz($student, 'SQL', 5);
        EntityManager::persist($quiz);
        EntityManager::flush();
    }
}
