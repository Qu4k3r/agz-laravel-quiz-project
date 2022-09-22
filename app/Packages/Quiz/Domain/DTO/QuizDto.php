<?php

namespace App\Packages\Quiz\Domain\DTO;

use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Student\Domain\Model\Student;

class QuizDto
{
    public function __construct(
        private ?Quiz $quiz = null,
        private ?Student $student = null,
        private ?string $subjectName = null,
        private ?int $totalQuestions = null,
        private ?float $score = null,
        private ?string $status = null,
        private ?array $questions = [],
    ) {}

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function getSubjectName(): ?string
    {
        return $this->subjectName;
    }

    public function getTotalQuestions(): ?int
    {
        return $this->totalQuestions;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getQuestions(): ?array
    {
        return $this->questions;
    }
}
