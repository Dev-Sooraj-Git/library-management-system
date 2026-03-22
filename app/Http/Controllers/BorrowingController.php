<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use App\Services\BorrowingService;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function borrow(Book $book, BorrowingService $service)
    {
        /** @var User $user */
        $user = auth()->user();

        try {
            $service->borrow($book, $user);
            return back()->with('success', 'Book borrowed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function return(Book $book, BorrowingService $service)
    {
        /** @var User $user */
        $user = auth()->user();

        try {
            $service->return($book, $user);
            return back()->with('success', 'Book returned successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function myBorrowings()
    {
        $borrowings = Borrowing::with(['book', 'book.author'])
            ->where('user_id', auth()->id())
            ->orderBy('borrowed_at', 'desc')
            ->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }
}
