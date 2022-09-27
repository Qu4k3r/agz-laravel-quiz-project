<?php

namespace App\Packages\Student\Tests\Unit\Student\Facade;

use App\Packages\Student\Domain\Model\Student;
use App\Packages\Student\Facade\StudentFacade;
use Tests\TestCase;

class StudentFacadeTest extends TestCase
{
    public function testIfCreatesStudent()
    {
        /** @var StudentFacade $studentFacade */
        $studentFacade = app(StudentFacade::class);
        $student = $studentFacade->create('John', 'Doe');
        $this->assertInstanceOf(Student::class, $student);
        $this->assertSame('John', $student->getName());
        $this->assertSame('Doe', $student->getLastname());
    }
}
