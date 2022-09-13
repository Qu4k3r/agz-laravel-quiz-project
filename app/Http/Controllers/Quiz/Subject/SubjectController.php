<?php

namespace App\Http\Controllers\Quiz\Subject;

use App\Packages\Quiz\Subject\Facade\SubjectFacade;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubjectController extends Controller
{
    public function __construct(private SubjectFacade $subjectFacade) {}

    public function create(Request $request): JsonResponse
    {
        try {
            $subject = $this->subjectFacade->getOrCreate(
                $request->get('name'),
            );
            $data = [
                'id' => $subject->getId(),
                'name' => $subject->getName(),
            ];

            return response()->success($data, statusCode: Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->error($exception->getMessage());
        }
    }
}
