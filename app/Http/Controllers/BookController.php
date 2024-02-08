<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $books = Book::with('feedbacks')->get();
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $book = Book::query()->create($request->all());
        return response()->json($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $book = Book::query()->where('id', $id)->first();
        return response()->json(
            $book ? $book : [
                'message' => 'Книга не найдена'
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $book = Book::query()->where('id', $id)->first();
        $book?->update($request->all());
        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        Book::query()->where('id', $id)->delete();
        return response()->json([
            'message' => 'This books has deleted'
        ]);
    }
}
