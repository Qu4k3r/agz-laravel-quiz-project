<?php

namespace Database\Seeders\Quiz\Question;

use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
       $this->createQuestions();
    }

    private function createQuestions(): void
    {
        if (EntityManager::getRepository(Question::class)->findOneBy([]) instanceof Question) {
            return;
        }
        $content = file_get_contents(base_path('database/seeders/Quiz/Question/Resources/questions.json'));
        $data = json_decode($content);

        foreach ($data->questions as $questionSeed) {
            $subject = EntityManager::getRepository(Subject::class)->findOneBy(['name' => $questionSeed->subjectName]);
            if (!$subject instanceof Subject) {
                $subject = new Subject($questionSeed->subjectName);
                EntityManager::persist($subject);
                EntityManager::flush();
            }

            $question = new Question($questionSeed->name, $subject);
            $this->seedAlternatives($questionSeed->alternatives, $question);
            EntityManager::persist($question);
        }
        EntityManager::flush();
    }

    private function seedAlternatives(array $alternatives, Question $question): void
    {
        foreach ($alternatives as $alternativeSeed) {
            $alternative = new Alternative($alternativeSeed->name, $question, $alternativeSeed->isCorrect);
            $question->addAlternative($alternative);
        }
    }
}
