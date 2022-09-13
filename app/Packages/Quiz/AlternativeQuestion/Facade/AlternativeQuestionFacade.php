<?php

namespace App\Packages\Quiz\AlternativeQuestion\Facade;

use App\Packages\Quiz\AlternativeQuestion\Domain\DTO\AlternativeQuestionDto;
use App\Packages\Quiz\AlternativeQuestion\Domain\Model\AlternativeQuestion;
use App\Packages\Quiz\AlternativeQuestion\Domain\Repository\AlternativeQuestionRepository;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Question\Domain\Repository\QuestionRepository;
use App\Packages\Quiz\Subject\Facade\SubjectFacade;

class AlternativeQuestionFacade
{
    public function __construct(
        private AlternativeQuestionRepository $alternativeQuestionRepository,
    ) {}

    public function getOrCreate(array $alternativeQuestions, Question $question): array
    {
        return array_map(function (array $alternativeQuestion) use ($question) {
            $alternativeQuestionDto = AlternativeQuestionDto::fromArray($alternativeQuestion);
            $alternativeQuestion = $this->alternativeQuestionRepository->findOneByNameAndQuestion($alternativeQuestionDto->getName(), $question);
            if ($alternativeQuestion instanceof AlternativeQuestion) {
                return $alternativeQuestion;
            }
            $alternativeQuestion = new AlternativeQuestion($alternativeQuestionDto->getName(), $question, $alternativeQuestionDto->isCorrect());
            $this->alternativeQuestionRepository->add($alternativeQuestion);

            return $alternativeQuestion;
        }, $alternativeQuestions);
    }

    public function createAlternative()
    {
        
    }
}
