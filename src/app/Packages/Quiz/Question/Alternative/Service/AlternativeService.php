<?php

namespace App\Packages\Quiz\Question\Alternative\Service;

use App\Packages\Quiz\Question\Alternative\Domain\DTO\AlternativeDto;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Alternative\Domain\Repository\AlternativeRepository;
use App\Packages\Quiz\Question\Domain\Model\Question;

class AlternativeService
{
    public function __construct(
        private AlternativeRepository $alternativeRepository,
    ) {}

    public function create(array $alternatives, Question $question): array
    {
        return array_map(function (array $alternative) use ($question) {
            $alternativeDto = AlternativeDto::fromArray($alternative);
            $alternative = new Alternative($alternativeDto->getName(), $question, $alternativeDto->isCorrect());
            $this->alternativeRepository->add($alternative);

            return $alternative;
        }, $alternatives);
    }
}
