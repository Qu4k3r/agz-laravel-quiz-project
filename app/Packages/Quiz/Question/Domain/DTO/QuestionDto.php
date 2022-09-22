<?php

namespace App\Packages\Quiz\Question\Domain\DTO;

use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Question\Alternative\Domain\DTO\AlternativeDto;

class QuestionDto
{
    public function __construct(
        private ?string $name = null,
        private array $alternatives = [],
        private ?string $studentAlternative = null,
        private ?bool $rightAnswer = null,
    ) {}

    public function toArray(string $quizStatus): array
    {
        return $quizStatus === Quiz::OPENED ? [
            'name' => $this->name,
            'alternatives' => AlternativeDto::fromArray($this->alternatives)->toArray($quizStatus),
        ] : [
            'name' => $this->name,
            'alternatives' => AlternativeDto::fromArray($this->alternatives)->toArray($quizStatus),
            'studentAlternative' => $this->studentAlternative,
            'rightAnswer' => $this->rightAnswer,
        ];
    }
}
