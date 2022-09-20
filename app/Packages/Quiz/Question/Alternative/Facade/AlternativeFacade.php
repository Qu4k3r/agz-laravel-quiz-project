<?php

namespace App\Packages\Quiz\Question\Alternative\Facade;

use App\Packages\Quiz\Exception\AlternativesLimitException;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Alternative\Service\AlternativeService;
use App\Packages\Quiz\Question\Domain\Model\Question;

class AlternativeFacade
{
    public function __construct(
        private AlternativeService $alternativeService,
    ) {}

    public function getOrCreate(array $alternatives, Question $question): array
    {
        $this->throwExceptionWhenRegistersMoreThanFourAlternatives($alternatives, $question);
        return $this->alternativeService->getOrCreate($alternatives, $question);
    }

    private function throwExceptionWhenRegistersMoreThanFourAlternatives(array $alternatives, Question $question): void
    {
        $alternativeQuestionsQuantity = count($question->getAlternatives());
        $alternativesQuantity = count($alternatives);
        $totalAlternatives = $alternativesQuantity + $alternativeQuestionsQuantity;
        $remainingAlternatives = Alternative::MAX_ALTERNATIVES_PER_QUESTION - $alternativeQuestionsQuantity;

        if ($alternativesQuantity > Alternative::MAX_ALTERNATIVES_PER_QUESTION ||
            $alternativeQuestionsQuantity === Alternative::MAX_ALTERNATIVES_PER_QUESTION
        ) {
            throw new AlternativesLimitException("It's not possible to register more than four alternatives per question", 1663709674);
        }

        if ($totalAlternatives > Alternative::MAX_ALTERNATIVES_PER_QUESTION) {
            throw new AlternativesLimitException("This question already has {$alternativeQuestionsQuantity} alternatives. It's possible to register only {$remainingAlternatives} more alternatives", 1663709675);
        }
    }
}
