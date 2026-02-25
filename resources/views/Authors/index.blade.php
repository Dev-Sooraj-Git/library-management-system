@extends('layouts.app')
@section('content')
<h1>Authors</h1>

<a href="{{ route('authors.create') }}">Add New Author</a>
<div class="container mt-5">
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        @foreach($authors as $author)
        <tr>
            <td>{{ $author->id }}</td>
            <td>{{ $author->name }}</td>
            <td>{{ $author->email }}</td>
            <td>
                <a href="{{ route('authors.edit', $author->id) }}">Edit</a>

                <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
<div class="mt-3">
    {{ $authors->links() }}
</div>
@endsection
