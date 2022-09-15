<?php

namespace App\Packages\Student\Facade;

use App\Packages\Student\Domain\Model\Student;
use App\Packages\Student\Domain\Repository\StudentRepository;

class StudentFacade
{
    public function __construct(private StudentRepository $studentRepository) {}

    public function create(string $name, string $lastName): Student
    {
        $student = new Student($name, $lastName);
        $this->studentRepository->add($student);

        return $student;
    }
}
