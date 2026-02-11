@extends('layouts.app')
@section('content')

<h1>Add Author</h1>

<form action="{{ route('authors.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Author Name" value="{{ old('name', $author->name ?? '') }}" required>
    <br><br>

    <input type="email" name="email" placeholder="Author Email" value="{{ old('email', $author->email ?? '') }}" required>
    <br><br>

    <button type="submit">Save</button>
</form>

@if ($errors->any())
<div style="color:red;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<a href="{{ route('authors.index') }}">Back</a>

@endsection
