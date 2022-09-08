<?php

namespace App\Packages\Quiz\Question\Command;

use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Console\Command;

class CreateQuestionCommand extends Command
{
    protected $signature = 'question:create';
    protected $description = 'Teste de criação de pergunta';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $mathSubject = new Subject(name: 'Matemática');
        $scienceSubject = new Subject(name: 'Ciências');
        $question = new Question('Qual a massa molar da água?', new ArrayCollection([$mathSubject, $scienceSubject]));
        dump($question->getQuiz());
    }
}
