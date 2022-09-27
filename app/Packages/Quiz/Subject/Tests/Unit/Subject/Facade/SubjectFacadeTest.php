<?php

namespace App\Packages\Quiz\Subject\Tests\Unit\Subject\Facade;

use App\Packages\Quiz\Subject\Domain\Model\Subject;
use App\Packages\Quiz\Subject\Facade\SubjectFacade;
use Database\Seeders\Quiz\Subject\SubjectSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectFacadeTest extends TestCase
{
    use RefreshDatabase;

    const STUDENT_TABLE = 'students',
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

        // then
        $this->assertInstanceOf(Subject::class, $subject);
        $this->assertDatabaseCount(self::STUDENT_TABLE, $databaseCount);
    }
}
