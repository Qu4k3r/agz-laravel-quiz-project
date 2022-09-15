<?php

namespace App\Packages\Quiz\Question\Alternative\Domain\DTO;

class AlternativeDto
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

    public static function fromArray(array $alternativeQuestions): AlternativeDto
    {
        return new self($alternativeQuestions['name'], $alternativeQuestions['isCorrect']);
    }
}
