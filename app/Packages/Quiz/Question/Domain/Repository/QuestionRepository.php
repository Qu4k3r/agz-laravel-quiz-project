<?php

namespace App\Packages\Quiz\Question\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\Question\Domain\Model\Question;

class QuestionRepository extends Repository
{
    protected string $entityName = Question::class;
}
