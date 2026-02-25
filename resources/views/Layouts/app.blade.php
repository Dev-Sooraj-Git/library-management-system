<!DOCTYPE html>
<html>

<head>
    <title>Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
