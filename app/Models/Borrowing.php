<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    // this is fillable
    protected $fillable = ['user_id','book_id','borrowed_at', 'due_date', 'returned_at', 'status'];

    // data type casing is here
    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('returned_at');
    }

    public function scopeOverdue($query)
    {
        return  $query->whereNull('returned_at')
                      ->where('due_date', '<', now());
    }

    public function scopeOverdue1($query){
        return $query->active()->where('due_date', '<',now());
    }
}
