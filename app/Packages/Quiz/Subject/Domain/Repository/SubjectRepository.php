<?php

namespace App\Packages\Quiz\Subject\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\Subject\Domain\Model\Subject;

class SubjectRepository extends Repository
{
    protected string $entityName = Subject::class;

    public function findOneByName(string $name): ?Subject
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function getRandomSubject(): ?Subject
    {
        $queryBuilder = $this->createQueryBuilder('subject');
        $queryBuilder
            ->orderBy('RANDOM()')
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
