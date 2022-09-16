<?php

namespace App\Packages\Quiz\Question\Domain\DTO;

use App\Packages\Quiz\Question\Alternative\Domain\DTO\AlternativeDto;
use App\Packages\Quiz\Question\Domain\Model\Question;

class QuestionDto
{
    private string $name;
    private string $subjectName;
    private array $alternatives;

    public function __construct(Question $question, ?array $alternatives = [])
    {
        $this->name = $question->getName();
        $this->subjectName = $question->getSubject()->getName();
        $this->alternatives = $alternatives;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'subject' => [
                'name' => $this->subjectName,
            ],
            'alternatives' => array_map(function (array $alternative) {
                $alternativeDto = AlternativeDto::fromArray($alternative);
                return $alternativeDto->toArray();
            }, $this->alternatives),
        ];
    }
}
