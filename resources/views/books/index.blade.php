@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>

    <form action="{{route('books.index')}}" method="GET" class="mb-4 flex gap-2">
        <input type="text" name="title" placeholder="Filter by title" class="input" value="{{request('title')}}" />
        <input type="hidden" name="filter" value="{{request('filter')}}"">
        <button type="submit" class="btn hover:bg-slate-500 hover:text-white hover:font-extrabold">Search</button>
        <a href="{{route('books.index')}}" class="h-10 w-20 border-2 border-orange-300 rounded-md p-2 text-orange-300 text-center">Clear</a>
    </form>

    <div class="filter-container mb-4 flex text-center p-2 gap-2">

        @php
            $filters = [
                '' =>'Latest',
                "popular_last_month"=>"Popular last month",
                "popular_last_6months"=>"Popular last 6 months",
                "highest_rated_last_month"=>"Highest rated last month",
                "highest_rated_last_6months"=>"Highest rated last 6 months",
            ];
        @endphp

        @foreach ($filters as $key => $value)   
            <a href="{{route('books.index', [...request()->query(), 'filter' => $key])}}"
            class="{{request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item'}} text-center">
                {{$value}}
            </a>
        @endforeach

    </div>

    <ul>
        @forelse ($books as $book)

        <li class="mb-4">
            <div class="book-item">
                <div
                class="flex flex-wrap items-center justify-between">
                <div class="w-full flex-grow sm:w-auto">
                    <a href="{{route('books.show', $book)}}" class="book-title">{{$book->title}}</a>
                    <span class="book-author">by {{$book->author}}</span>
                </div>
                <div>
                    <div class="book-rating">
                    {{number_format($book->reviews_avg_rating,1)}}
                    </div>
                    <div class="book-review-count">
                    out of {{$book->reviews_count}} {{Str::plural('review',$book->reviews_count)}}
                    </div>
                </div>
                </div>
            </div>
        </li>

        @empty

        <li class="mb-4">
            <div class="empty-book-item">
                <p class="empty-text">No books found</p>
                <a href="{{route('books.index')}}" class="reset-link">Reset criteria</a>
            </div>
        </li>

        @endforelse

    </ul>
@endsection
