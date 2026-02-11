@extends('layouts.app')

@section('content')
<h1>Edit Book</h1>

<form action="{{ route('books.update', $book->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Title</label><br>
    <input type="text" name="title" value="{{ $book->title }}" required><br><br>

    <label>Author</label><br>
    <select name="author_id" required>
        @foreach($authors as $author)
        <option value="{{ $author->id }}"
            {{ $book->author_id == $author->id ? 'selected' : '' }}>
            {{ $author->name }}
        </option>
        @endforeach
    </select><br><br>

    <button type="submit">Update</button>
</form>
@endsection
