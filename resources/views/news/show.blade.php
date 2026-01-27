@extends('layouts.myapp')

@section('content')
    <div class="flex flex-col lg:flex-row gap-12">
        <div class="lg:w-2/3">
            <div class="bg-white shadow-sm rounded-2xl overflow-hidden mb-8 border border-gray-100">
                <div class="p-8">
                    @if($news->category)
                        <a href="{{ route('news.index', ['category' => $news->category->id]) }}" class="inline-block bg-blue-50 text-blue-600 text-[10px] px-3 py-1 rounded-full uppercase font-black tracking-widest mb-6 hover:bg-blue-100 transition-colors">
                            {{ $news->category->name }}
                        </a>
                    @endif

                    <h1 class="text-3xl sm:text-5xl font-black text-gray-900 mb-6 leading-tight">{{ $news->title }}</h1>
                    
                    <div class="flex items-center justify-between mb-8 pb-8 border-b border-gray-50">
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-black shadow-lg">
                                {{ substr($news->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-gray-900 font-black text-base">{{ $news->user ? $news->user->name : 'Unknown' }}</p>
                                <p class="text-gray-400 text-xs font-medium">{{ $news->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 text-gray-400 font-bold text-sm bg-gray-50 px-4 py-2 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>{{ number_format($news->views) }} lượt xem</span>
                        </div>
                    </div>

                    @if($news->image_path)
                        <div class="mb-10 rounded-2xl overflow-hidden shadow-2xl">
                            <img src="{{ asset('storage/' . $news->image_path) }}" alt="{{ $news->title }}" class="w-full h-auto object-cover max-h-[600px]">
                        </div>
                    @endif

                    <div class="mb-8 flex flex-wrap gap-2">
                        @foreach($news->tags as $tag)
                            <a href="{{ route('news.index', ['tag' => $tag->id]) }}" class="bg-gray-100 text-gray-500 text-xs font-bold px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    
                    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed mb-8">
                        {!! $news->content !!}
                    </div>
                </div>
            </div>

            {{-- Flash message --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Comments Section --}}
            <div class="bg-white shadow-sm rounded-2xl p-8 border border-gray-100">
                <h3 class="text-2xl font-black text-gray-900 mb-8 flex items-center">
                    Bình luận
                    <span class="ml-3 text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded-full">{{ $comments->total() }}</span>
                </h3>
                
                <div class="mb-10">
                    @auth
                        @include('comments._form', ['news' => $news])
                    @else
                        <div class="p-6 bg-blue-50 rounded-2xl text-center border border-blue-100">
                            <p class="text-blue-900 font-bold">Vui lòng <a href="{{ route('login') }}" class="text-blue-600 underline">đăng nhập</a> để để lại bình luận.</p>
                        </div>
                    @endauth
                </div>

                @include('comments._list', ['comments' => $comments])

                {{-- Pagination --}}
                <div class="mt-6 flex justify-center">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:w-1/3">
            @include('partials.trending_news')
        </div>
    </div>
@endsection