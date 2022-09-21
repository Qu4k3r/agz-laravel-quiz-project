<?php

namespace App\Packages\Quiz\Facade;

use App\Packages\Quiz\Domain\DTO\QuizDto;
use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Domain\Model\Score;
use App\Packages\Quiz\Domain\Repository\QuizRepository;
use App\Packages\Quiz\Exception\QuizAlreadyFinishedException;
use App\Packages\Quiz\Exception\QuizFinishedAfterOneHourException;
use App\Packages\Quiz\Exception\QuizNotFinishedException;
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

        $quizDto = $this->generateQuizDto($quiz, $questions);
        $this->snapshotFacade->create($quizDto);

        return $quizDto;
    }

    private function generateQuizDto(Quiz $quiz, array $questions = []): QuizDto
    {
        return (new QuizDto())
            ->setQuiz($quiz)
            ->setStudent($quiz->getStudent())
            ->setSubjectName($quiz->getSubjectName())
            ->setTotalQuestions($quiz->getTotalQuestions())
            ->setQuestions($questions);
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
//        $totalQuestions = Quiz::generateTotalQuestions();
        $totalQuestions = 3;
        $quiz = new Quiz($student, $subjectName, $totalQuestions);
        $this->quizRepository->add($quiz);

        return $quiz;
    }

    public function update(Quiz $quiz, array $answeredQuestions): QuizDto
    {
//        $this->throwExceptionIfQuizFinishedAfterOneHour($quiz);
//        $this->throwExceptionIfQuizAlreadyFinished($quiz);
        $quizDto = $this->generateAnsweredQuizDto($quiz, $answeredQuestions);
        dd();
        return $this->generateAnsweredQuizDto($quiz, $answeredQuestions);
    }

    private function generateAnsweredQuizDto(Quiz $quiz, array $answeredQuestions): QuizDto
    {
        $questions = $this->snapshotFacade->getFormattedAnsweredQuestionsFromSnapshot(
            $quiz, $answeredQuestions
        );

        dd(
            array_reduce($questions, function ($carry, $question) {
                return $question['rightAnswer'] ? $carry + Score::ONE_POINT : $carry;
            }, Score::INITIAL)
        );

        $score = $this->calculateScore();
        return $this->generateQuizDto($quiz, $questions);
    }

    private function calculateScore(array $formattedAnsweredQuestions): float
    {
        $totalQuestions = count($formattedAnsweredQuestions);
        $totalRightAnswers = array_reduce(
            $formattedAnsweredQuestions,
            fn ($carry, $question) => $question['rightAnswer'] ?
                $carry + Score::ONE_POINT :
                $carry, Score::INITIAL
        );

        return bcdiv($totalRightAnswers, $totalQuestions, Score::SCALE);
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
            throw new QuizAlreadyFinishedException("Quiz already finished!", 1663720546);
        }
    }
}
