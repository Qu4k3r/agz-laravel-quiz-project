<?php

namespace App\Packages\Quiz\Facade;

use App\Packages\Quiz\Domain\DTO\QuizDto;
use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Domain\Model\Score;
use App\Packages\Quiz\Domain\Repository\QuizRepository;
use App\Packages\Quiz\Exception\QuizAlreadyFinishedException;
use App\Packages\Quiz\Exception\QuizFinishedAfterOneHourException;
use App\Packages\Quiz\Exception\QuizIncompleteException;
use App\Packages\Quiz\Exception\QuizNotFinishedException;
use App\Packages\Quiz\Question\Domain\DTO\QuestionDto;
use App\Packages\Quiz\Question\Facade\QuestionFacade;
use App\Packages\Quiz\Snapshot\Facade\SnapshotFacade;
use App\Packages\Quiz\Subject\Facade\SubjectFacade;
use App\Packages\Student\Domain\Model\Student;

class QuizFacade
{
    public function __construct(
        private QuizRepository $quizRepository,
        private QuestionFacade $questionFacade,
        private SubjectFacade $subjectFacade,
        private SnapshotFacade $snapshotFacade,
    ) {}

    public function create(Student $student): QuizDto
    {
        $this->throwExceptionIfStudentHasOpenedQuiz($student);

        $subject = $this->subjectFacade->getRandomSubject();
        $quiz = $this->generateQuiz($student, $subject->getName());
        $questions = $this->questionFacade->getRandomQuestionsBySubjectAndTotalQuestions(
            $subject->getName(), $quiz->getTotalQuestions()
        );
        $this->questionFacade->shuffleAlternatives($questions);

        $quizDto = new QuizDto(
            $quiz,
            $student,
            $subject->getName(),
            $quiz->getTotalQuestions(),
            status: Quiz::OPENED,
            questions: $questions
        );
        $this->snapshotFacade->create($quizDto);

        return $quizDto;
    }

    private function throwExceptionIfStudentHasOpenedQuiz(Student $student): void
    {
        $quiz = $this->quizRepository->findOneByStudentAndStatus($student, Quiz::OPENED);
        if ($quiz instanceof Quiz) {
            throw new QuizNotFinishedException("Please finish OPENED quiz before creating a new one!", 1663297548);
        }
    }

    private function generateQuiz(Student $student, string $subjectName): Quiz
    {
        $totalQuestions = Quiz::generateTotalQuestions();
        $quiz = new Quiz($student, $subjectName, $totalQuestions);
        $this->quizRepository->add($quiz);

        return $quiz;
    }

    public function update(Quiz $quiz, array $answeredQuestions): QuizDto
    {
        $this->throwExceptionIfQuizAlreadyFinished($quiz);
        $this->throwExceptionIfQuizFinishedAfterOneHour($quiz);
        $this->throwExceptionIfQuizIsIncomplete($quiz->getTotalQuestions(), $answeredQuestions);

        $quiz->setStatus(Quiz::CLOSED);
        $questions = $this->snapshotFacade->getFormattedAnsweredQuestionsFromSnapshot(
            $quiz, $answeredQuestions
        );
        $score = $this->calculateScore($questions);
        $quiz->setScore($score);
        $questionsName = array_keys($questions);

        $questionDtoArray = array_map(
            fn (string $questionName) => new QuestionDto(
                $questionName,
                $questions[$questionName]['alternatives'],
                $questions[$questionName]['studentAlternative'],
                in_array(true,$questions[$questionName]['rightAnswer']),
            ),
            $questionsName
        );

        return new QuizDto(
            $quiz,
            $quiz->getStudent(),
            $quiz->getSubjectName(),
            $quiz->getTotalQuestions(),
            $quiz->getScore(),
            Quiz::CLOSED,
            $questionDtoArray
        );
    }

    private function calculateScore(array $formattedAnsweredQuestions): float
    {
        $totalQuestions = count($formattedAnsweredQuestions);
        $rightAnswers = array_reduce(
            $formattedAnsweredQuestions,
            fn ($carry, $question) => in_array(true,$question['rightAnswer']) ?
                $carry + Score::ONE_POINT :
                $carry, Score::INITIAL
        );

        $score = bcdiv($rightAnswers, $totalQuestions, Score::SCALE);

        return bcmul($score, Score::MAX, Score::SCALE);
    }

    private function throwExceptionIfQuizFinishedAfterOneHour(Quiz $quiz)
    {
        if ($quiz->wasFinishedAfterOneHour()) {
            throw new QuizFinishedAfterOneHourException("Quiz delivered after one hour!", 1663721106);
        }
    }

    private function throwExceptionIfQuizAlreadyFinished(Quiz $quiz): void
    {
        if ($quiz->isFinished()) {
            throw new QuizAlreadyFinishedException('Quiz already finished!', 1663720546);
        }
    }

    private function throwExceptionIfQuizIsIncomplete(int $totalQuestions, array $answeredQuestions)
    {
        if (count($answeredQuestions) !== $totalQuestions) {
            throw new QuizIncompleteException('Quiz is incomplete. Please, review your data!', 1664913055);
        }
    }
}
