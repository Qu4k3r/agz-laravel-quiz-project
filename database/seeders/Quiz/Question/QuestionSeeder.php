<?php

namespace Database\Seeders\Quiz\Question;

use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
       $this->createQuestionBySubject('05bbf3b3-5b7a-41a7-a7e7-6e6e001065a8');
       $this->createQuestionBySubject('60d611d8-4100-4857-9d81-1d38b1c82e65', 'Qual o retorno da função "array_key_exists" quando a chave não existe?', 'PHP');
       $this->createQuestionBySubject(name: 'Qual o nome da funcao que mostra o valor de uma variavel no console?', subjectName: 'JAVASCRIPT');
       $this->createQuestionBySubject(name: 'O que faz a operacao JOIN?', subjectName: 'SQL');
    }

    private function createQuestionBySubject(string $id = null, string $name = null, string $subjectName = null): void
    {
        if (!is_null($id) && EntityManager::getRepository(Question::class)->findOneBy(['id' => $id]) instanceof Question) {
            return;
        }

        if (is_null($name)) {
            $name = 'O que significa os numeros 0 e 1 no mundo da computação?';
        }

        if (is_null($subjectName)) {
            $subjectName = 'Conhecimentos Gerais';
        }

        $subject = EntityManager::getRepository(Subject::class)->findOneBy(['name' => $subjectName]);

        $question = new Question($name, $subject);

        EntityManager::persist($question);
        if (!is_null($id)) {
            $question->setId($id);
            EntityManager::merge($question);
        }
        EntityManager::flush();
    }
}
