@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Book</h2>

    <form method="POST" action="{{ route('books.store') }}">
        @csrf

        <div>
            <label>Book Title</label>
            <input type="text" name="title" value="{{ old('title') }}">
            @error('title') <small>{{ $message }}</small> @enderror
        </div>

        <div>
            <label>Author</label>
            <select name="author_id">
                <option value="">-- Select Author --</option>
                @foreach($authors as $author)
                <option value="{{ $author->id }}"
                    {{ old('author_id') == $author->id ? 'selected' : '' }}>
                    {{ $author->name }}
                </option>
                @endforeach
            </select>
            @error('author_id') <small>{{ $message }}</small> @enderror
        </div>

        <button type="submit">Save</button>
    </form>
</div>
@endsection
