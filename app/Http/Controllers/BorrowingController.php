<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    //

    // app/Http/Controllers/BorrowingController.php
    public function borrow(Book $book)
    {
        // Check availability
        if ($book->available_copies < 1) {
            return back()->with('error', 'Book not available');
        }

        DB::beginTransaction();

        try {
            // Create borrowing record
            Borrowing::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'borrowed_at' => now(),
                'due_date' => now()->addDays(14),
                'status' => 'borrowed'
            ]);

            // Decrease available copies
            $book->decrement('available_copies');

            DB::commit();

            return back()->with('success', 'Book borrowed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function return(Book $book)
    {
        DB::beginTransaction();

        try {
            $borrowing = Borrowing::where('book_id', $book->id)
                ->where('user_id', auth()->id())
                ->whereNull('returned_at')
                ->first();

            if (!$borrowing) {
                return back()->with('error', 'You haven\'t borrowed this book');
            }

            $borrowing->update([
                'returned_at' => now(),
                'status' => 'returned'
            ]);

            $book->increment('available_copies');

            DB::commit();

            return back()->with('success', 'Book returned successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
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
