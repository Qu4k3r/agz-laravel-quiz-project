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

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(string $quizStatus): array
    {
        return $quizStatus === Quiz::OPENED ? [
            'name' => $this->name,
            'alternatives' => array_map(
                fn (array $alternative) => AlternativeDto::fromArray($alternative)->toArray($quizStatus),
                $this->alternatives
            ),
        ] : [
            'name' => $this->name,
            'correctAlternative' => array_values($this->getOnlyCorrectAlternatives())[0]['name'],
            'studentAlternative' => $this->studentAlternative,
            'rightAnswer' => $this->rightAnswer,
        ];
    }

    private function getOnlyCorrectAlternatives(): array
    {
        return array_filter(
            $this->alternatives, fn (array $alternative, ) => $alternative['isCorrect']
        );
    }
}
