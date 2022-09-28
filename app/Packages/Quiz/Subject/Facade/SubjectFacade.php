<?php

namespace App\Packages\Quiz\Subject\Facade;

use App\Packages\Quiz\Subject\Domain\Model\Subject;
use App\Packages\Quiz\Subject\Domain\Repository\SubjectRepository;

class SubjectFacade
{
    public function __construct(private SubjectRepository $subjectRepository) {}

    public function getOrCreate(string $subjectName): Subject
    {
        $subject = $this->subjectRepository->findOneByName($subjectName);
        if ($subject instanceof Subject) {
            return $subject;
        }

        $subject = new Subject($subjectName);
        $this->subjectRepository->add($subject);

        return $subject;
    }

    public function getRandomSubject(): ?Subject
    {
        return $this->subjectRepository->getRandomSubject();
    }
}
