<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author_id', 'total_copies'];

    protected $casts = [
        'total_copies' => 'integer',
        'available_copies' => 'integer',
    ];

    // ========== RELATIONSHIPS ==========

    // Q: "Who wrote this book?"
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    // Q: "What are all borrowing records of this book?"
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    // Q: "Which users borrowed this book?"
    public function users()
    {
        return $this->belongsToMany(User::class, 'borrowings')
                    ->withPivot('borrowed_at', 'due_date', 'returned_at', 'status')
                    ->withTimestamps();
    }

    // ========== QUERY SCOPES (Reusable filters) ==========

    // to get all the available books
    public function scopeAvailable($query)
    {
        return $query->where('available_copies', '>', 0);
    }

    // to get the list of book, which are out of stock
    public function scopeOutOfStock($query)
    {
        return $query->where('available_copies', 0);
    }

    // ========== HELPER METHODS ==========

    // to check weather a book available or not
    public function isAvailable()
    {
        return $this->available_copies > 0;
    }

    // to get the copies are currently borrowed
    public function borrowedCopiesCount()
    {
        return $this->total_copies - $this->available_copies;
    }

    // to get the currently active borrowings
    public function activeBorrowings()
    {
        return $this->borrowings()->whereNull('returned_at');
    }
}
