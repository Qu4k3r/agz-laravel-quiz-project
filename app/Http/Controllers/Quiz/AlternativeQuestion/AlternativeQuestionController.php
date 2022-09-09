<?php

namespace App\Http\Controllers\Quiz\AlternativeQuestion;

use App\Packages\Quiz\Subject\Facade\SubjectFacade;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlternativeQuestionController extends Controller
{
    public function __construct(private AlternativeQuestionFacade $alternativeQuestionFacade) {}

    public function create(Request $request): JsonResponse
    {
        try {
            $subject = $this->subjectFacade->create(
                $request->get('name'),
            );
            $data = [
                'id' => $subject->getId(),
                'name' => $subject->getName(),
            ];

            return response()->success($data, statusCode: Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }
}
