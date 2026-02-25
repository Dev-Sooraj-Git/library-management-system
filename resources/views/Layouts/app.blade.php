<!DOCTYPE html>
<html>

<head>
    <title>Library Management</title>
</head>

<body>

    <nav>
        <a href="{{ route('authors.index') }}">Authors</a> |
        @if(Route::has('books.index'))
        <a href="{{ route('books.index') }}">Books</a>
        @endif
    </nav>

    <hr>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div style="max-width:800px; margin:auto;">
        @yield('content')
    </div>

</body>

</html>
