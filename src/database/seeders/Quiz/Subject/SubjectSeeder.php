<?php

namespace Database\Seeders\Quiz\Subject;

use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
       $this->createSubject();
    }

    private function createSubject(): void
    {
        if (EntityManager::getRepository(Subject::class)->findOneBy([]) instanceof Subject) {
            return;
        }

        $content = file_get_contents(base_path('database/seeders/Quiz/Subject/Resources/subjects.json'));
        $data = json_decode($content);

        foreach ($data->subjects as $subject) {
            $subject = new Subject($subject->name);
            EntityManager::persist($subject);
        }
        EntityManager::flush();
    }
}
