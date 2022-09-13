<?php

namespace App\Packages\Quiz\Question\Facade;

use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Question\Domain\Repository\QuestionRepository;
use App\Packages\Quiz\Subject\Facade\SubjectFacade;

class QuestionFacade
{
    public function __construct(
        private SubjectFacade $subjectFacade,
        private QuestionRepository $questionRepository,
    ) {}

    public function create(string $name, string $subjectName): Question
    {
        $subject = $this->subjectFacade->getOrCreate($subjectName);
        $question = new Question($name, $subject);
        $this->questionRepository->add($question);

        return $question;
    }
}
