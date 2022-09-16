<?php

namespace App\Http\Controllers;

use App\Packages\Quiz\Facade\QuizFacade;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Student\Domain\Model\Student;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{

    public function __construct(
        private QuizFacade $quizFacade,
    ) {}

    public function create(Student $student)
    {
        try {
            $quizDto = $this->quizFacade->create($student);
            $data = [
                'quizId' => $quizDto->getQuiz()->getId(),
                'studentId' => $quizDto->getStudent()->getId(),
                'subjectName' => $quizDto->getSubjectName(),
                'totalQuestions' => $quizDto->getTotalQuestions(),
                'questions' => array_map(function (Question $question) {
                    return [
                        'name' => $question->getName(),
                        'alternatives' => array_map(function ($alternative) {
                            return [
                                'name' => $alternative->getName(),
                            ];
                        }, $question->getAlternatives()),
                    ];
                }, $quizDto->getQuestions()),
            ];
            return response()->success($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
