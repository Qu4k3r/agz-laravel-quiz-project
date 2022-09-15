<?php

namespace App\Packages\Quiz\Question\Alternative\Facade;

use App\Packages\Quiz\Question\Alternative\Domain\DTO\AlternativeDto;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Alternative\Domain\Repository\AlternativeRepository;
use App\Packages\Quiz\Question\Domain\Model\Question;

class AlternativeFacade
{
    public function __construct(
        private AlternativeRepository $alternativeQuestionRepository,
    ) {}

    public function getOrCreate(array $alternativeQuestions, Question $question): array
    {
        return array_map(function (array $alternativeQuestion) use ($question) {
            $alternativeQuestionDto = AlternativeDto::fromArray($alternativeQuestion);
            $alternativeQuestion = $this->alternativeQuestionRepository->findOneByNameAndQuestion($alternativeQuestionDto->getName(), $question);
            if ($alternativeQuestion instanceof Alternative) {
                return $alternativeQuestion;
            }
            $alternativeQuestion = new Alternative($alternativeQuestionDto->getName(), $question, $alternativeQuestionDto->isCorrect());
            $this->alternativeQuestionRepository->add($alternativeQuestion);

            return $alternativeQuestion;
        }, $alternativeQuestions);
    }
}
