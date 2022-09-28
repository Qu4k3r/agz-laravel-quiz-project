<?php

namespace App\Packages\Quiz\Subject\Tests\Unit\Subject\Facade;

use App\Packages\Quiz\Subject\Domain\Model\Subject;
use App\Packages\Quiz\Subject\Facade\SubjectFacade;
use Database\Seeders\Quiz\Subject\SubjectSeeder;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class SubjectFacadeTest extends TestCase
{
    const STUDENT_TABLE = 'subjects',
        QUANTITY_IF_NOT_EXISTS = 4,
        QUANTITY_IF_EXISTS = 3;

    public function subjectProvider(): array
    {
        return [
            'subjectDoesNotExistInDatabase' => [
                'name' => 'Java',
                'instance' => Subject::class,
                'databaseCount' => self::QUANTITY_IF_NOT_EXISTS
            ],
            'subjectExistsInDatabase' => [
                'name' => 'Laravel',
                'instance' => Subject::class,
                'databaseCount' => self::QUANTITY_IF_EXISTS
            ]
        ];
    }

    /** @dataProvider subjectProvider */
    public function testIfCreatesSubject(string $name, string $instance, int $databaseCount): void
    {
        // given
        $this->seed(SubjectSeeder::class);

        /** @var SubjectFacade $subjectFacade */
        $subjectFacade = app(SubjectFacade::class);

        // when
        $subject = $subjectFacade->getOrCreate($name);
        EntityManager::flush();
        $subjects = EntityManager::getRepository(Subject::class)->findAll();

        // then
        $this->assertInstanceOf(Subject::class, $subject);
        $this->assertSame($databaseCount, count($subjects));
    }

    public function randomSubjectProvider(): array
    {
        return [
            'Seeding database' => [
                'seed' => true,
            ],
            'Not seeding database' => [
                'seed' => false,
            ],
        ];
    }

    /** @dataProvider randomSubjectProvider */
    public function testShouldReturnNullOrOneRandomSubject(bool $seed)
    {
        // given
        if ($seed) {
            $this->seed(SubjectSeeder::class);
        }

        /** @var SubjectFacade $subjectFacade */
        $subjectFacade = app(SubjectFacade::class);

        // when
        $subject = $subjectFacade->getRandomSubject();

        // then
        if ($seed) {
            $this->assertNotNull($subject);
            $this->assertInstanceOf(Subject::class, $subject);
            return;
        }
        $this->assertNull($subject);
    }
}
