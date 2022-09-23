<?php

namespace App\Http\Controllers;

use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Domain\Repository\QuizRepository;
use App\Packages\Quiz\Facade\QuizFacade;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Domain\DTO\QuestionDto;
use App\Packages\Quiz\Question\Domain\Model\Question;
use App\Packages\Quiz\Snapshot\Domain\Model\Snapshot;
use App\Packages\Quiz\Snapshot\Domain\Repository\SnapshotRepository;
use App\Packages\Student\Domain\Model\Student;
use App\Packages\Student\Domain\Repository\StudentRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{

    public function __construct(
        private QuizFacade $quizFacade,
    ) {}

    public function create(Student $student): JsonResponse
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
                        'alternatives' => array_map(
                            fn (Alternative $alternative) => ['name' => $alternative->getName()],
                            $question->getAlternatives()
                        )
                    ];
                }, $quizDto->getQuestions()),
            ];
            return response()->success($data, statusCode: Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, Quiz $quiz): JsonResponse
    {
        try {
            $answeredQuestions = $request->all();
            $quizDto = $this->quizFacade->update($quiz, $answeredQuestions);
            $data = [
                'quizId' => $quizDto->getQuiz()->getId(),
                'studentId' => $quizDto->getStudent()->getId(),
                'subjectName' => $quizDto->getSubjectName(),
                'totalQuestions' => $quizDto->getTotalQuestions(),
                'questions' => array_map(
                    fn (QuestionDto $questionDto) => $questionDto->toArray(Quiz::CLOSED),
                    $quizDto->getQuestions()
                ),
                'score' => $quizDto->getScore(),
                'status' => $quizDto->getStatus(),
            ];
            return response()->success($data, statusCode: Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
