<?php

namespace App\Http\Controllers\Quiz\AlternativeQuestion;

use App\Http\Controllers\Controller;
use App\Packages\Quiz\AlternativeQuestion\Domain\Model\AlternativeQuestion;
use App\Packages\Quiz\AlternativeQuestion\Facade\AlternativeQuestionFacade;
use App\Packages\Quiz\Question\Domain\Model\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlternativeQuestionController extends Controller
{
    public function __construct(
        private AlternativeQuestionFacade $alternativeQuestionFacade,
    ) {}

    public function create(Request $request, Question $question): JsonResponse
    {
        try {
            $requesttAlternativeQuestions = $request->all();
            $alternativeQuestions = $this->alternativeQuestionFacade->getOrCreate($requesttAlternativeQuestions, $question);

            $data = array_map(fn (AlternativeQuestion $alternativeQuestion) => [
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
