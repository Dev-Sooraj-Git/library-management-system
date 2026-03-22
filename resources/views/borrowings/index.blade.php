@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-semibold mb-6">My Borrowed Books</h1>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @forelse($borrowings as $borrowing)
                    <div class="border-b border-gray-200 py-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $borrowing->book->title }}</h3>
                                <p class="text-gray-600">by {{ $borrowing->book->author->name }}</p>
                                <p class="text-sm text-gray-500">Borrowed: {{ $borrowing->borrowed_at->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-500">Due: {{ $borrowing->due_date->format('M d, Y') }}</p>
                                <p class="text-sm mt-1">
                                    Status:
                                    @if($borrowing->status === 'borrowed')
                                        <span class="text-yellow-600 font-medium">Borrowed</span>
                                    @else
                                        <span class="text-green-600 font-medium">Returned</span>
                                    @endif
                                </p>
                            </div>

                            @if(!$borrowing->returned_at)
                                <form action="{{ route('books.return', $borrowing->book) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Return Book
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">You haven't borrowed any books yet.</p>
                @endforelse

                <div class="mt-6">
                    {{ $borrowings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
