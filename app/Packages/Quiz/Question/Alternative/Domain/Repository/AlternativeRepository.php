<?php

namespace App\Packages\Quiz\Question\Alternative\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Domain\Model\Question;
use Doctrine\ORM\Query\Expr;

class AlternativeRepository extends Repository
{
    protected string $entityName = Alternative::class;

    public function findOneByNameAndQuestion(string $name, Question $question): ?Alternative
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
