<?php

namespace App\Http\Controllers\Quiz\Student;

use App\Http\Controllers\Controller;
use App\Packages\Student\Facade\StudentFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public function __construct(private StudentFacade $studentFacade) {}

    public function create(Request $request): JsonResponse
    {
        try {
            $student = $this->studentFacade->create(
                $request->get('name'),
                $request->get('lastName'),
            );
            $data = [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'lastName' => $student->getLastname(),
            ];

            return response()->success($data, statusCode: Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->error($exception->getMessage());
        }
    }
}
