<?php

namespace App\Packages\Quiz\Question\Domain\DTO;

use App\Packages\Quiz\Question\Domain\Model\Question;

class QuestionDto
{
    private string $id;
    private string $name;
    private string $subjectId;
    private string $subjectName;

    public function __construct(Question $question)
    {
        $this->id = $question->getId();
        $this->name = $question->getName();
        $this->subjectId = $question->getSubject()->getId();
        $this->subjectName = $question->getSubject()->getName();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSubjectId(): string
    {
        return $this->subjectId;
    }

    public function getSubjectName(): string
    {
        return $this->subjectName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subject' => [
                'id' => $this->subjectId,
                'name' => $this->subjectName,
            ],
        ];
    }
}
