<?php

namespace App\Packages\Quiz\Tests\Unit\Quiz\Facade;

use App\Packages\Quiz\Exception\QuizNotFinishedException;
use App\Packages\Quiz\Facade\QuizFacade;
use App\Packages\Student\Domain\Model\Student;
use Database\Seeders\DatabaseTestSeeder;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class QuizFacadeTest extends TestCase
{
    public function testThrowsExceptionWhenCreatesQuizIfStudentHasOpenedQuiz(): void
    {
        $this->seed(DatabaseTestSeeder::class);
        $student = EntityManager::getRepository(Student::class)->findOneBy(['lastname' => 'Neves']);
        $this->expectException(QuizNotFinishedException::class);
        $this->expectExceptionCode(1663297548);
        $this->expectExceptionMessage('Please finish OPENED quiz before creating a new one!');
        app(QuizFacade::class)->create($student);
    }
}
