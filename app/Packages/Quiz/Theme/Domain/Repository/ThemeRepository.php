<?php

namespace App\Packages\Quiz\Subject\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\Subject\Domain\Model\Theme;

class ThemeRepository extends Repository
{
    protected string $entityName = Theme::class;

    public function getRandom(): ?Theme
    {
        $queryBuilder = $this->createQueryBuilder('subject');
        $queryBuilder
            ->orderBy('RANDOM()')
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }
}
