<?php

namespace App\Packages\Student\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Student\Domain\Model\Student;

class StudentRepository extends Repository
{
    protected string $entityName = Student::class;

    public function findOneByRegisterId(int $registerId): ?Student
    {
        return $this->findOneBy(['registerId' => $registerId]);
    }
}
