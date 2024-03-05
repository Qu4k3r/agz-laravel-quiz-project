<?php

namespace App\Packages\Quiz\Question\Alternative\Tests\Unit\Alternative\Facade;

use App\Packages\Quiz\Exception\AlternativesLimitException;
use App\Packages\Quiz\Question\Alternative\Facade\AlternativeFacade;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Tests\TestCase;

class AlternativeFacadeTest extends TestCase
{
    public function alternativesProvider(): array
    {
        return [
            '3 alternatives' => [
                [
                    'name' => '.',
                    'isCorrect' => false
                ],
                [
                    'name' => '..',
                    'isCorrect' => false
                ],
                [
                    'name' => '...',
                    'isCorrect' => true
                ],
            ],
            '5 alternatives' => [
                [
                    'name' => '.',
                    'isCorrect' => false
                ],
                [
                    'name' => '..',
                    'isCorrect' => false
                ],
                [
                    'name' => '...',
                    'isCorrect' => false
                ],
                [
                    'name' => '....',
                    'isCorrect' => false
                ],
                [
                    'name' => '.....',
                    'isCorrect' => true
                ],
            ],
        ];
    }

    /** @dataProvider alternativesProvider */
    public function testItThrowsExceptionWhenNotRegistersFourAlternativesPerQuestion(array $alternatives): void
    {
        // given
        /** @var AlternativeFacade $alternativeFacade */
        $alternativeFacade = app(AlternativeFacade::class);
        $subjectStub = $this->createStub(Subject::class);
        $question = new Question('What is a database?', $subjectStub);

        // then
        $this->expectException(AlternativesLimitException::class);
        $this->expectExceptionCode(1663709674);
        $this->expectExceptionMessage('You must register four alternatives per question');

        // when
        $alternativeFacade->create($alternatives, $question);
    }
}
