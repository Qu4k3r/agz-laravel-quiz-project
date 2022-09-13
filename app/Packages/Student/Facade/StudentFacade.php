<?php

namespace App\Packages\Student\Facade;

use App\Packages\Student\Domain\Model\Student;
use App\Packages\Student\Domain\Repository\StudentRepository;

class StudentFacade
{
    public function __construct(private StudentRepository $studentRepository) {}

    public function getOrCreate(string $name, string $lastName, int $registerId): Student
    {
        $student = $this->studentRepository->findOneByRegisterId($registerId);
        if ($student instanceof Student) {
            return $student;
        }

        $student = new Student($name, $lastName, $registerId);
        $this->studentRepository->add($student);

        return $student;
    }
}
