<?php

namespace App\Packages\Quiz\Question\Command;

use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Question\Service\QuestionService;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Console\Command;

class CreateQuestionCommand extends Command
{
    protected $signature = 'question:create';
    protected $description = 'Teste de criação de pergunta';

    public function __construct(private QuestionService $questionService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->questionService->generateRandomQuestions();
    }
}
