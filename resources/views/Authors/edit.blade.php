@extends('layouts.app')
@section('content')

<h1>Edit Author</h1>

<form action="{{ route('authors.update', $author->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Name</label><br>
        <input
            type="text"
            name="name"
            value="{{ old('name', $author->name) }}"
            required>
    </div>

    <br>

    <div>
        <label>Email</label><br>
        <input
            type="email"
            name="email"
            value="{{ old('email', $author->email) }}"
            required>
    </div>

    <br>

    <button type="submit">Update Author</button>
</form>

<br>

@if ($errors->any())
<div style="color:red;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<a href="{{ route('authors.index') }}">⬅ Back to Authors</a>

@endsection
