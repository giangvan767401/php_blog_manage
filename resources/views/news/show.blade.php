@extends('layouts.myapp')

@section('content')
    <div class="container">
        <h1>{{ $news->title }}</h1>

        <p>{!! nl2br(e($news->content)) !!}</p>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Comment form Option 2: chỉ cho phép đã đăng nhập mới bình luận, nếu đã cài breeze --}}
        <div class="card mb-4">
            <div class="card-body">
                @auth
                    @include('comments._form', ['news' => $news])
                @else
                    {{-- If you want guests to be able to comment, include the form directly here (remove @auth wrapper) --}}
                    <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi bình luận.</p>
                @endauth
            </div>
        </div>
        {{--hết comment form--}}

        {{-- Comments list --}}
        @include('comments._list', ['comments' => $comments])

        {{-- Pagination links (centered) --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $comments->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection