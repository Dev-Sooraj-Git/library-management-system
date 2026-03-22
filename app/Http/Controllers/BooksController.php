<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // FETCH ALL DATA
        $books = Book::with('author')->latest()->paginate(5);
        return view('Books.index', compact('books'));
        // return Book::all();
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $authors = Author::select('id', 'name')->get();
        return view('books.create', compact('authors'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the inputs provided by user/admin.
        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books')->where(function ($q) use ($request) {
                    return $q->where('author_id', $request->author_id);
                }),
            ],
            'author_id' => 'required|exists:authors,id',
            'total_copies' => 'required|integer|min:1'
        ]);

        $data['available_copies'] = $data['total_copies'];
        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::select('id', 'name')->get();
        return view('books.edit', compact('book', 'authors'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books')
                    ->where(fn($q) => $q->where('author_id', $request->author_id))
                    ->ignore($book->id),
            ],
            'author_id' => 'required|exists:authors,id',
            'total_copies' => 'required|integer|min:1'
        ]);

        $oldCopies = $book->total_copies;
        $newCopies = $data['total_copies'];
        $difference = $newCopies - $oldCopies;

        $newAvailable = $book->available_copies + $difference;

        // Prevent negative available copies
        if ($newAvailable < 0) {
            return back()->withErrors(['total_copies' => 'Cannot remove more copies than available']);
        }

        $data['available_copies'] = $newAvailable;

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book Updated!');;
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index');
    }
}
