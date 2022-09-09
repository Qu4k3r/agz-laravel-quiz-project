<?php

namespace App\Packages\Quiz\Subject\Facade;

use App\Packages\Quiz\Subject\Domain\Model\Subject;
use App\Packages\Quiz\Subject\Domain\Repository\SubjectRepository;

class SubjectFacade
{
    public function __construct(private SubjectRepository $subjectRepository) {}

    public function create(string $name): Subject
    {
        $subject = new Subject($name);
        $this->subjectRepository->add($subject);

        return $subject;
    }
}
