<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    public function index()
    {
        // dd('API reached!');
        $books = Book::with('author')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $books,
            'message' => 'Books retrieved successfully'
        ]);
    }

    public function show(Book $book)
    {
        return response()->json([
            'success' => true,
            'data' => $book->load('author'),
            'message' => 'Book retrieved successfully'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'total_copies' => 'required|integer|min:1'
        ]);

        $validated['available_copies'] = $validated['total_copies'];

        $book = Book::create($validated);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book created successfully'
        ], 201);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'total_copies' => 'required|integer|min:1'
        ]);

        $oldCopies = $book->total_copies;
        $newCopies = $validated['total_copies'];
        $difference = $newCopies - $oldCopies;
        $newAvailable = $book->available_copies + $difference;

        if ($newAvailable < 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot remove more copies than available'
            ], 422);
        }

        $validated['available_copies'] = $newAvailable;
        $book->update($validated);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book updated successfully'
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully'
        ]);
    }
}
