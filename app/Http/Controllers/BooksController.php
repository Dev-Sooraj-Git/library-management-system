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
        $books = Book::all();
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
        ]);
        Book::create($data);

        return redirect()->route('books.index');
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
        ]);

        $book->update($data);

        return redirect()->route('books.index');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index');
    }
}
