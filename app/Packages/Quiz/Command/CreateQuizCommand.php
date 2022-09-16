<?php

namespace App\Packages\Quiz\Command;

use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Question\Domain\DTO\QuestionDto;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use App\Packages\Student\Domain\Model\Student;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Console\Command;
use LaravelDoctrine\ORM\Facades\EntityManager;

class CreateQuizCommand extends Command
{
    protected $signature = 'quiz:create';
    protected $description = 'Teste de criação de quiz';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $student = new Student(name: 'João', lastname: 'Silva', registerId: 123456);
        EntityManager::persist($student);
        $subject = new Subject(name: 'MATEMATICA');
        EntityManager::persist($subject);

        $questionsCollection = new ArrayCollection([
            new Question('Quanto eh 5 x 7?', $subject),
            new Question('Qual a raiz de 4?', $subject),
            new Question('Qual a formula do comprimento de uma circunferencia?', $subject),
        ]);

        $questions = $questionsCollection->map(function (Question $question) {
            EntityManager::persist($question);
            return (new QuestionDto($question))->toArray(true);
        });

        $quiz = new Quiz(student: $student, subject: $subject, totalQuestions: $questionsCollection->count(), generatedQuestions: $questions->toArray());
        EntityManager::persist($quiz);
        EntityManager::flush();
        $this->info('Quiz criado com sucesso!');
    }
}
