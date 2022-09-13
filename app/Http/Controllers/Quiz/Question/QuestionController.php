<?php

namespace App\Http\Controllers\Quiz\Question;

use App\Http\Controllers\Controller;
use App\Packages\Quiz\Question\Facade\QuestionFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    public function __construct(
        private QuestionFacade $questionFacade,
    ) {}

    public function create(Request $request): JsonResponse
    {
        try {
            $question = $this->questionFacade->getOrCreate(
                $request->get('name'),
                $request->get('subjectName'),
            );
            $data = [
                'id' => $question->getId(),
                'name' => $question->getName(),
                'subject' => [
                    'id' => $question->getSubject()->getId(),
                    'name' => $question->getSubject()->getName(),
                ],
            ];

            return response()->success($data, statusCode: Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->error($exception->getMessage());
        }
    }
}
