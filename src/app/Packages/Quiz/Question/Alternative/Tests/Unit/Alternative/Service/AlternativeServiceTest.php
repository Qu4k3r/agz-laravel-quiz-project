<?php

namespace App\Packages\Quiz\Question\Alternative\Tests\Unit\Alternative\Facade;

use App\Packages\Quiz\Exception\AlternativesLimitException;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Alternative\Facade\AlternativeFacade;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Database\Seeders\DatabaseTestSeeder;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class AlternativeServiceTest extends TestCase
{
    public function testCreatesFourAlternativesPerQuestion(): void
    {
        // given
        $this->seed(DatabaseTestSeeder::class);
        /** @var AlternativeFacade $alternativeFacade */
        $alternativeFacade = app(AlternativeFacade::class);
        $subject = EntityManager::getRepository(Subject::class)->findOneBy(['name' => 'SQL']);
        $question = new Question('What is a database?', $subject);

        // when
        $alternativesData = [
            ['name' => '.', 'isCorrect' => false],
            ['name' => '..', 'isCorrect' => false],
            ['name' => '...', 'isCorrect' => false],
            ['name' => '....', 'isCorrect' => true],
        ];
        $alternatives = $alternativeFacade->create($alternativesData, $question);

        // then
        $this->assertSame(Alternative::MAX_ALTERNATIVES_PER_QUESTION, count($alternatives));
        $this->assertInstanceOf(Alternative::class, $alternatives[0]);
    }
}
