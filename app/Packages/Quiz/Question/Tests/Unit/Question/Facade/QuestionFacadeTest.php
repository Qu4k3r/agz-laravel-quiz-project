<?php

namespace App\Packages\Quiz\Question\Tests\Unit\Question\Facade;

use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Question\Facade\QuestionFacade;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Carbon\Carbon;
use Database\Seeders\DatabaseTestSeeder;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class QuestionFacadeTest extends TestCase
{
    public function testShouldShuffleAlternativesQuestion(): void
    {
        // given
        $subjectStub = $this->createStub(Subject::class);
        $question = new Question('teste', $subjectStub);

        $alternative1 = $this->createStub(Alternative::class);
        $alternative2 = $this->createStub(Alternative::class);
        $alternative3 = $this->createStub(Alternative::class);
        $alternative4 = $this->createStub(Alternative::class);

        $question->addAlternative($alternative1);
        $question->addAlternative($alternative2);
        $question->addAlternative($alternative3);
        $question->addAlternative($alternative4);

        $alternativesBeforeShuffle = $question->getAlternatives();

        // when
        app(QuestionFacade::class)->shuffleAlternatives([$question]);
        $alternativesAfterShuffle = $question->getAlternatives();

        // then
        $this->assertNotSame($alternativesBeforeShuffle, $alternativesAfterShuffle);
    }

    public function randomQuestionsProvider(): array
    {
        return [
          'provide 10 random questions' => [
              'subjectName' => 'SQL',
              'totalQuestions' => 10,
          ],
          'provide 7 random questions' => [
              'subjectName' => 'SQL',
              'totalQuestions' => 7,
          ],
          'provide 5 random questions' => [
              'subjectName' => 'SQL',
              'totalQuestions' => 5,
          ],
        ];
    }

    /** @dataProvider randomQuestionsProvider */
    public function testShouldGetRandomQuestionsBySubjectAndTotalQuestions(string $subjectName, int $totalQuestions): void
    {
        // given
        $this->seed(DatabaseTestSeeder::class);

        $firstNQuestions = collect(EntityManager::getRepository(Question::class)->findBy([], limit: $totalQuestions));

        // when
        $randomQuestions = collect(app(QuestionFacade::class)->getRandomQuestionsBySubjectAndTotalQuestions($subjectName, $totalQuestions));

        /** @var Question $question */
        $question = $randomQuestions->first();

        // then
        $this->assertSame($subjectName, $question->getSubject()->getName());
        $this->assertSame($totalQuestions, $randomQuestions->count());
        $this->assertNotSame($firstNQuestions, $randomQuestions);
    }

    public function casesProvider(): array
    {
        return [
            'question name already exists in database' => [
                'name' => 'What is Database?',
                'subjectName' => 'SQL',
                'totalQuestions' => 10,
            ],
            'question name does not exist in database' => [
                'name' => 'What are Models?',
                'subjectName' => 'SQL',
                'totalQuestions' => 11
            ],
        ];
    }

    /** @dataProvider casesProvider */
    public function testShouldGetOrCreateQuestion(string $name, string $subjectName, int $totalQuestions)
    {
        $this->seed(DatabaseTestSeeder::class);

        /** @var Question $question */
        $question = app(QuestionFacade::class)->getOrCreate($name, $subjectName);
        EntityManager::flush();
        $questionsQuantity = count(EntityManager::getRepository(Question::class)->findAll());

        $this->assertInstanceOf(Question::class, $question);
        $this->assertSame($totalQuestions, $questionsQuantity);
    }
}
