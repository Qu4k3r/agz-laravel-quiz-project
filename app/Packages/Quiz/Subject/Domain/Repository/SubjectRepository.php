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
}
