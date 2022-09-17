<?php

namespace Database\Seeders\Quiz\Subject;

use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
       $this->createSubject('fde5d485-e454-4156-bcd8-f0ccc8dc66be', 'Conhecimentos Gerais');
       $this->createSubject('84e5dacc-8eb0-45b2-8286-73909f9acf40', 'JAVASCRIPT');
       $this->createSubject('e1e7bebc-1802-412c-922d-929fde71cf9f', 'SQL');
       $this->createSubject('98ed7ffe-7251-4adc-806f-449fde54a693', 'PHP');
    }

    private function createSubject(string $id = null, string $name = null): void
    {
        if (!is_null($id) && EntityManager::getRepository(Subject::class)->findOneBy(['id' => $id]) instanceof Subject) {
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
