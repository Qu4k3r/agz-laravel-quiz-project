<?php

namespace App\Packages\Quiz\AlternativeQuestion\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\AlternativeQuestion\Domain\Model\AlternativeQuestion;
use App\Packages\Quiz\Question\Domain\Model\Question;
use Doctrine\ORM\Query\Expr;

class AlternativeQuestionRepository extends Repository
{
    protected string $entityName = AlternativeQuestion::class;

    public function findOneByNameAndQuestion(string $name, Question $question): ?AlternativeQuestion
    {
        $queryBuilder = $this->createQueryBuilder('alternativeQuestion');
        $queryBuilder
            ->join('alternativeQuestion.question', 'question', Expr\Join::WITH, 'question.id = :questionId')
            ->where('alternativeQuestion.name = :name')
            ->setParameters([
                'name' => $name,
                'questionId' => $question->getId(),
            ])
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
