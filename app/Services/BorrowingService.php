<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BorrowingService
{
    public function borrow(Book $book, User $user)
    {
        if ($book->available_copies < 1) {
            throw new \Exception('Book not available');
        }

        DB::beginTransaction();

        try {
            Borrowing::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrowed_at' => now(),
                'due_date' => now()->addDays(14),
                'status' => 'borrowed'
            ]);

            $book->decrement('available_copies');

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function return(Book $book, User $user)
    {
        DB::beginTransaction();

        try {
            $borrowing = Borrowing::where('book_id', $book->id)
                                  ->where('user_id', $user->id)
                                  ->whereNull('returned_at')
                                  ->first();

            if (!$borrowing) {
                throw new \Exception('You haven\'t borrowed this book');
            }

            $borrowing->update([
                'returned_at' => now(),
                'status' => 'returned'
            ]);

            $book->increment('available_copies');

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
