<?php

namespace App\Packages\Quiz\Snapshot\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Snapshot\Domain\Model\Snapshot;
use App\Packages\Student\Domain\Model\Student;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\QueryBuilder;

class SnapshotRepository extends Repository
{
    protected string $entityName = Snapshot::class;

    public function getByQuiz(Quiz $quiz): array
    {
        $queryBuilder = $this->queryBuilder();
        $queryBuilder
            ->select('s.questionName, s.alternativeName, s.isCorrect, s.studentAlternative, s.rightAnswer')
            ->from(Snapshot::class, 's')
            ->where('s.quiz = :quiz')
            ->setParameter('quiz', $quiz->getId());
        return $queryBuilder->getQuery()->getResult();
    }

    public function updateByQuiz(Quiz $quiz, array $question): void
    {
        $queryBuilder = $this->queryBuilder();
        $queryBuilder
            ->update(Snapshot::class,'snapshots')
            ->set('snapshots.studentAlternative', ':studentAlternative')
            ->set('snapshots.rightAnswer', 'CASE WHEN (snapshots.alternativeName = :studentAlternative AND snapshots.isCorrect = TRUE) THEN TRUE ELSE FALSE END')
            ->where('snapshots.quiz = :quizId AND snapshots.questionName = :questionName')
            ->setParameters([
                'studentAlternative' => $question['answer'],
                'questionName' => $question['name'],
                'quizId' => $quiz->getId(),
            ])
            ->getQuery()
            ->execute();
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->_em->createQueryBuilder();
    }

    public function teste(): array
    {
        return [
             [
                'questionName' => [
                    'alternatives' => [
                        'name',
                        'isCorrect',
                    ],
                    'studentAlternative' => 'bla bla ...',
                    'rightAnswer' => true
                ]
            ],
            [
                'question' => 'bla bla ...',
                'alternative' => 'bla bla ...',
                'isCorrect' => true,
                'studentAlternative' => 'bla bla ...',
                'rightAnswer' => true,
            ],
            [
                'question' => 'bla bla ...',
                'alternative' => 'bla bla ...',
                'isCorrect' => true,
                'studentAlternative' => 'bla bla ...',
                'rightAnswer' => true,
            ]
        ];
    }
}
