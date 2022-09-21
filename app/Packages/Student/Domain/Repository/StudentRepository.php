<?php

namespace App\Packages\Student\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Student\Domain\Model\Student;

class StudentRepository extends Repository
{
    protected string $entityName = Student::class;
}
