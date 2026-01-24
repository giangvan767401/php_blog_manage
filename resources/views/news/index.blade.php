@extends('layouts.myapp')
@section('title', 'Danh Sách Tin Tức')

@section('content')
    <h1>Danh Sách Tin Tức</h1>

    @auth
        <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">Thêm tin tức mới</a>
    @endauth

    <ul>
        @foreach ($news as $item)
            <li>
                <h3>
                    <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                </h3>
                <p>{{ $item->summary }}</p>
                @if(auth()->check()&&auth()->user()->role==='admin')
                    <a href="{{ route('news.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
                    
                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xoá</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>

    <div>
        {{ $news->links() }}
    </div>
@endsection