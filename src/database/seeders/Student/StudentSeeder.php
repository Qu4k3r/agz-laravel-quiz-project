<?php

namespace Database\Seeders\Student;

use App\Packages\Student\Domain\Model\Student;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
       $this->createStudent();
    }

    private function createStudent(): void
    {
        if (EntityManager::getRepository(Student::class)->findOneBy([]) instanceof Student) {
            return;
        }

        $content = file_get_contents(base_path('database/seeders/Student/Resources/students.json'));
        $data = json_decode($content);

        foreach ($data->students as $student) {
            $student = new Student($student->name, $student->lastname);
            EntityManager::persist($student);
        }
        EntityManager::flush();
    }
}
