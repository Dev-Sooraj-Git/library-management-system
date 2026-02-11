@extends('layouts.app')

@section('content')
<h1>Books</h1>

<a href="{{ route('books.create') }}">Add New Book</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Actions</th>
    </tr>

    @foreach($books as $book)
    <tr>
        <td>{{ $book->id }}</td>
        <td>{{ $book->title }}</td>
        <td>{{ $book->author->name ?? '-' }}</td>
        <td>
            <a href="{{ route('books.edit', $book->id) }}">Edit</a>

            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
