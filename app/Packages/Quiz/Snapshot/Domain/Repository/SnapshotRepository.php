<?php

namespace App\Packages\Quiz\Snapshot\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Snapshot\Domain\Model\Snapshot;
use App\Packages\Student\Domain\Model\Student;
use Doctrine\ORM\QueryBuilder;

class SnapshotRepository extends Repository
{
    protected string $entityName = Snapshot::class;

    public function getByQuiz(Quiz $quiz): array
    {
        return $this->findBy(['quiz' => $quiz->getId()]);
    }

    public function updateByQuiz(Quiz $quiz, array $alternative)
    {
        $queryBuilder = $this->queryBuilder();
        $queryBuilder
            ->update(Snapshot::class,'snapshots')
            ->set('snapshots.studentAlternative', ':studentAlternative')
            ->set('snapshots.rightAnswer', 'CASE WHEN (snapshots.alternativeName = :studentAlternative AND snapshots.isCorrect = TRUE) THEN TRUE ELSE FALSE END')
            ->where('snapshots.quiz = :quizId AND snapshots.questionName = :questionName')
            ->setParameters([
                'studentAlternative' => $alternative['answer'],
                'questionName' => $alternative['question'],
                'quizId' => $quiz->getId(),
            ])
            ->getQuery()
            ->execute();
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->_em->createQueryBuilder();
    }
}
