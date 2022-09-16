<?php

namespace App\Packages\Quiz\Domain\DTO;

use App\Packages\Student\Domain\Model\Student;

class QuizDto
{
    private string $id;
    private Student $student;
    private string $subjectName;
    private int $totalQuestions;
    private array $questions;

    public function __construct()
    {

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): QuizDto
    {
        $this->id = $id;
        return $this;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): QuizDto
    {
        $this->student = $student;
        return $this;
    }

    public function getSubjectName(): string
    {
        return $this->subjectName;
    }

    public function setSubjectName(string $subjectName): QuizDto
    {
        $this->subjectName = $subjectName;
        return $this;
    }

    public function setTotalQuestions(int $totalQuestions): QuizDto
    {
        $this->totalQuestions = $totalQuestions;
        return $this;
    }

    public function getTotalQuestions(): int
    {
        return $this->totalQuestions;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function setQuestions(array $questions): QuizDto
    {
        $this->questions = $questions;
        return $this;
    }
}
