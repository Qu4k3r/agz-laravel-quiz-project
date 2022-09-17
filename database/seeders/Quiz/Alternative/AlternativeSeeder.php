<?php

namespace Database\Seeders\Quiz\Alternative;

use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class AlternativeSeeder extends Seeder
{
    public function run(): void
    {

    }

    private function createAlternative(string $id = null, string $name = null): void
    {
        if (!is_null($id) && EntityManager::getRepository(Alternative::class)->findOneBy(['id' => $id]) instanceof Alternative) {
            return;
        }

        if (is_null($name)) {
            $name = 'Conhecimentos Gerais';
        }

        $subjectRepository = EntityManager::getRepository(Subject::class);
        $subject = $subjectRepository->findOneBy(['name' => $name]);
        if (!$subject instanceof Subject) {
            $subject = new Subject($name);
            EntityManager::persist($subject);
            if (!is_null($id)) {
                $subject->setId($id);
                EntityManager::merge($subject);
            }
            EntityManager::flush();
        }
    }
}
