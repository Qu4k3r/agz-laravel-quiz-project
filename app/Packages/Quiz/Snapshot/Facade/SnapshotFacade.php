<?php

namespace App\Packages\Quiz\Snapshot\Facade;


use App\Packages\Quiz\Domain\DTO\QuizDto;
use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Snapshot\Domain\Model\Snapshot;
use App\Packages\Quiz\Snapshot\Domain\Repository\SnapshotRepository;

class SnapshotFacade
{
    public function __construct(private SnapshotRepository $snapshotRepository) {}

    public function create(QuizDto $quizDto): void
    {
        $questions = $quizDto->getQuestions();
        foreach ($questions as $question) {
            foreach ($question->getAlternatives() as $alternative) {
                $snapShot = new Snapshot($quizDto->getQuiz(), $quizDto->getStudent(), $quizDto->getSubjectName(), $question->getName(), $alternative->getName(), $alternative->isCorrect());
                $this->snapshotRepository->add($snapShot);
            }
        }
    }

    public function update(Quiz $quiz, array $answers): void
    {
        $snapshots = $this->snapshotRepository->getByQuiz($quiz);
        foreach ($snapshots as $snapshot) {
            $snapshot->setAnswer($answers[$snapshot->getQuestionName()]);
            $this->snapshotRepository->update($snapshot);
        }
    }
}
