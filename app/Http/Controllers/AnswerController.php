<?php

namespace App\Http\Controllers;

use App\Events\StoreAnswerEvent;
use App\Models\Answer;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $answers = Answer::query()->paginate(10);
        return response()->json($answers);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $answer = Answer::query()->create([
            'description' => $request->description,
            'feedback_id' => $request->feedback_id,
            'user_id' => Auth::user()->id,
        ]);

        broadcast(new StoreAnswerEvent($answer));

        return response()->json($answer);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $answer = Answer::query()->where('id', $id)->first();
        return response()->json($answer);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $answer = Answer::query()->where('id', $id)->first();
        $answer->update([
            'description' => $request->description,
        ]);
        return response()->json($answer);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        Answer::query()->where('id', $id)->first();
        return response()->json([
            'message' => 'Ответ успешно удален'
        ]);
    }
}
