<?php

namespace App\Packages\Quiz\Question\Service;

use App\Packages\Quiz\Question\Domain\Repository\QuestionRepository;

class QuestionService
{
    public function __construct(private QuestionRepository $questionRepository) {}

    public function generateRandomQuestions(): array
    {
        $limit = rand(1, 20);
        $questions = $this->questionRepository->getRandomQuestions($limit);
        dd($questions);
    }
}
