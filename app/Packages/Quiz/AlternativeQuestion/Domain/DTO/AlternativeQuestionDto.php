<?php

namespace App\Packages\Quiz\AlternativeQuestion\Domain\DTO;

use App\Packages\Quiz\Question\Domain\Model\Question;

class AlternativeQuestionDto
{
    private string $name;
    private bool $isCorrect;

    public function __construct(string $name, bool $isCorrect)
    {
        $this->name = $name;
        $this->isCorrect = $isCorrect;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isCorrect(): string
    {
        return $this->isCorrect;
    }

    public static function fromArray(array $alternativeQuestions): AlternativeQuestionDto
    {
        return new self($alternativeQuestions['name'], $alternativeQuestions['isCorrect']);
    }
}
