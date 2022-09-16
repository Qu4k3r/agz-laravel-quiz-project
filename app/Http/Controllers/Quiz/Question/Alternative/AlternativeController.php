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
        private AlternativeFacade $alternativeQuestionFacade,
    ) {}

    public function create(Request $request, Question $question): JsonResponse
    {
        try {
            $requesttAlternativeQuestions = $request->all();
            $alternativeQuestions = $this->alternativeQuestionFacade->getOrCreate($requesttAlternativeQuestions, $question);

            $data = array_map(fn (Alternative $alternativeQuestion) => [
                'id' => $alternativeQuestion->getId(),
                'name' => $alternativeQuestion->getName(),
                'isCorrect' => $alternativeQuestion->isCorrect()
            ], $alternativeQuestions);

            return response()->success($data, statusCode: Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->error($exception->getMessage());
        }
    }
}
