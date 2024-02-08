<?php

namespace App\Http\Controllers;

use App\Events\StoreFeedbackEvent;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $feedbacks = Feedback::with('answers')->paginate(10);
        return response()->json($feedbacks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $feedback = Feedback::query()->create([
            'description' => $request->description,
            'book_id' => $request->book_id,
            'user_id' => Auth::user()->id,
        ]);
        event(new StoreFeedbackEvent($feedback));
        return response()->json($feedback);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $feedback = Feedback::query()->where('id', $id)->first();
        return response()->json($feedback);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $feedback = Feedback::query()->where('id', $id)->first();
        $feedback->update([
            'description' => $request->description,
        ]);;
        return response()->json($feedback);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        Feedback::query()->where('id', $id)->first();
        return response()->json([
            'message' => 'Отзыв успешно удален'
        ]);
    }
}
