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
       $this->createQuestions();
    }

    private function createQuestions(): void
    {
        if (EntityManager::getRepository(Question::class)->findOneBy([]) instanceof Question) {
            return;
        }
        $content = file_get_contents(base_path('database/seeders/Quiz/Question/Resources/questions.json'));
        $data = json_decode($content);

        foreach ($data->questions as $question) {
            $subject = EntityManager::getRepository(Subject::class)->findOneBy(['name' => $question->subjectName]);
            if (!$subject instanceof Subject) {
                continue;
            }
            $question = new Question($question->name, $subject);
            EntityManager::persist($question);
        }
        EntityManager::flush();
    }
}
