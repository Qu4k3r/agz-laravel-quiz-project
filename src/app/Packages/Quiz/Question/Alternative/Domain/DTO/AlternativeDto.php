<?php

namespace App\Packages\Quiz\Question\Alternative\Domain\DTO;

use App\Packages\Quiz\Domain\Model\Quiz;

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

    public static function fromArray(array $alternative): AlternativeDto
    {
        return new self($alternative['name'], $alternative['isCorrect']);
    }

    public function toArray(string $quizStatus): array
    {
        return $quizStatus === Quiz::OPENED ?
            ['name' => $this->name] :
            ['name' => $this->name, 'isCorrect' => $this->isCorrect];
    }
}
