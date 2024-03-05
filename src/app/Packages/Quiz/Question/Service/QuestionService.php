<?php

namespace App\Packages\Quiz\Question\Service;

use App\Packages\Quiz\Question\Domain\Repository\QuestionRepository;

class QuestionService
{
    public function __construct(private QuestionRepository $questionRepository) {}

    public function generateRandomQuestions(): array
    {
        $totalQuestions = rand(1, 10);
        $questions = $this->questionRepository->getRandomQuestions($totalQuestions);
        dd($questions);
    }
}
