<?php

namespace App\Http\Controllers\Quiz\Question\Alternative;

use App\Http\Controllers\Controller;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
use App\Packages\Quiz\Question\Alternative\Facade\AlternativeFacade;
use App\Packages\Quiz\Question\Domain\Model\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlternativeController extends Controller
{
    public function __construct(
        private AlternativeFacade $alternativeFacade,
    ) {}

    public function create(Request $request, Question $question): JsonResponse
    {
        try {
            $requestAlternativeQuestions = $request->all();
            $alternativeQuestions = $this->alternativeFacade->create($requestAlternativeQuestions, $question);

            $data = array_map(fn (Alternative $alternative) => [
                'id' => $alternative->getId(),
                'name' => $alternative->getName(),
                'isCorrect' => $alternative->isCorrect()
            ], $alternativeQuestions);

            return response()->success($data, statusCode: Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->error($exception->getMessage());
        }
    }
}
