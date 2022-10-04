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

    public function create(array $alternatives, Question $question): array
    {
        $this->throwExceptionWhenNotRegistersFourAlternatives($alternatives);
        return $this->alternativeService->create($alternatives, $question);
    }

    private function throwExceptionWhenNotRegistersFourAlternatives(array $alternatives): void
    {
        $alternativesQuantity = count($alternatives);
        if ($alternativesQuantity !== Alternative::MAX_ALTERNATIVES_PER_QUESTION) {
            throw new AlternativesLimitException('You must register four alternatives per question', 1663709674);
        }
    }
}
