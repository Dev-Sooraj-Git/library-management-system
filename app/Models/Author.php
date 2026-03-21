<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    protected $fillable = ['name', 'email'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function borrowings(){
        return $this->hasManyThrough(
            Borrowing::class, // final table
            Book::class, // intermediate table
            'author_id', // author -> book
            'book_id', // book -> borrowing
            'id', // local id
            'id' // local id
        );
    }
}
