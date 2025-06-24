<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" >
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/books.css') }}">
</head>
<body>
    @include('header')
    <form method="GET" action="{{ route('books.index3') }}">
        <input type="text" name="search" placeholder="Tìm kiếm sách..." value="{{ request()->search }}">
        <button class="btn1" type="submit">Tìm kiếm</button>
    </form>
    <div class="book-container">
        @if ($books->isEmpty())
        <p>Không tìm thấy sách</p>
        @else
        @foreach ($books as $book)
            <div class="book">
                <img src="{{ asset('images/' . $book->image) }}" alt="{{ $book->title }}">
                <h3>{{ $book->title }}</h3>
                <p>{{ $book->formatted_price }}đ</p>
                <a href="{{ route('books.show', $book->id) }}" class="btn">Xem ngay</a>

            </div>
        @endforeach
        @endif
    </div>
    <div class="pagination">
        {{ $books->links() }}
    </div>

    @include('footer')
</body>
</html>