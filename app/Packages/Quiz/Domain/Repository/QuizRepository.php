<?php

namespace App\Packages\Quiz\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Student\Domain\Model\Student;

class QuizRepository extends Repository
{
    protected string $entityName = Quiz::class;

    public function findOneByStudentAndStatus(Student $student, string $status): ?Quiz
    {
        $queryBuilder = $this->createQueryBuilder('quiz');
        $queryBuilder
            ->where('quiz.student = :student')
            ->andWhere('quiz.status = :status')
            ->setParameters([
                'student' => $student,
                'status' => $status,
            ])
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }
}
