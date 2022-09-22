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

    private function getAndUpdate(Quiz $quiz, array $answeredQuestions): array
    {
        foreach ($answeredQuestions as $question) {
            $this->snapshotRepository->updateByQuiz($quiz, $question);
        }

        return $this->snapshotRepository->getByQuiz($quiz);
    }

    public function getFormattedAnsweredQuestionsFromSnapshot(Quiz $quiz, array $answeredQuestions): array
    {
        $snapshots = $this->getAndUpdate($quiz, $answeredQuestions);

        $questions = [];
        foreach ($snapshots as $snapshot) {
            if (!isset($questions[$snapshot['questionName']])) {
                $questions[$snapshot['questionName']]['alternatives'] = [
                    'name' => $snapshot['alternativeName'],
                    'isCorrect' => $snapshot['isCorrect'],
                ];
            } else {
                $questions[$snapshot['questionName']]['alternatives'][] = [
                    'name' => $snapshot['alternativeName'],
                    'isCorrect' => $snapshot['isCorrect'],
                ];
            }
            $questions[$snapshot['questionName']]['studentAlternative'] = $snapshot['studentAlternative'];
            $questions[$snapshot['questionName']]['rightAnswer'] = $snapshot['rightAnswer'];
        }

        return $questions;
    }
}
