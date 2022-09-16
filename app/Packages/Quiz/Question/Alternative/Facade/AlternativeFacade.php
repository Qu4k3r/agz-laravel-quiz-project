<?php

namespace App\Packages\Quiz\Question\Alternative\Facade;

use App\Packages\Quiz\Question\Alternative\Service\AlternativeService;
use App\Packages\Quiz\Question\Domain\Model\Question;

class AlternativeFacade
{
    public function __construct(
        private AlternativeService $alternativeService,
    ) {}

    public function getOrCreate(array $alternatives, Question $question): array
    {
        return $this->alternativeService->getOrCreate($alternatives, $question);
    }
}
