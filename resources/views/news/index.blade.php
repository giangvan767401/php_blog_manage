@extends('layouts.myapp')
@section('title', 'Danh Sách Tin Tức')

@section('content')
    {{-- Featured Hot News Carousel --}}
    @if($featuredNews->count() > 0)
        <div class="relative mb-12 group/carousel" id="hot-news-carousel">
            <div class="overflow-hidden rounded-2xl shadow-xl">
                <div class="flex transition-transform duration-500 ease-out" id="carousel-track">
                    @foreach($featuredNews as $index => $item)
                        <div class="w-full flex-shrink-0">
                            <div class="bg-white flex flex-col md:flex-row min-h-[450px]">
                                @if($item->image_path)
                                    <div class="md:w-3/5">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover min-h-[300px] md:min-h-[450px]">
                                    </div>
                                @endif
                                <div class="md:w-2/5 p-8 md:p-12 flex flex-col justify-center bg-gradient-to-br from-white to-gray-50 border-r border-gray-100">
                                    <div class="flex items-center space-x-2 mb-4">
                                        <span class="bg-red-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter animate-pulse">Tin Nóng</span>
                                        @if($item->category)
                                            <span class="text-blue-600 text-[10px] font-bold uppercase tracking-widest">{{ $item->category->name }}</span>
                                        @endif
                                    </div>
                                    <h2 class="text-2xl md:text-4xl font-black text-gray-900 mb-4 hover:text-red-600 transition-colors duration-300 leading-tight">
                                        <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                                    </h2>
                                    <p class="text-gray-500 text-base mb-6 line-clamp-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($item->content), 180) }}
                                    </p>
                                    <div class="flex items-center justify-between mt-auto">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border-2 border-white shadow-sm text-xs">
                                                {{ substr($item->user->name ?? 'A', 0, 1) }}
                                            </div>
                                            <div class="text-xs">
                                                <p class="text-gray-900 font-black">{{ $item->user->name ?? 'Unknown' }}</p>
                                                <p class="text-gray-400 font-medium flex items-center">
                                                    {{ $item->created_at->format('M d, Y') }}
                                                    <span class="mx-1">&bull;</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    {{ number_format($item->views) }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('news.show', $item->id) }}" class="inline-flex items-center text-red-600 font-black text-sm hover:translate-x-2 transition-transform duration-300">
                                            Đọc ngay 
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Navigation Buttons - Only show if > 1 item --}}
            @if($featuredNews->count() > 1)
                <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 backdrop-blur-md hover:bg-black/60 text-white p-3 rounded-full shadow-2xl transition-all duration-300 opacity-0 group-hover/carousel:opacity-100 z-10 border border-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 backdrop-blur-md hover:bg-black/60 text-white p-3 rounded-full shadow-2xl transition-all duration-300 opacity-0 group-hover/carousel:opacity-100 z-10 border border-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                
                {{-- Indicators --}}
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 bg-black/20 backdrop-blur-sm px-3 py-2 rounded-full">
                    @foreach($featuredNews as $index => $item)
                        <div class="carousel-dot block h-1.5 rounded-full transition-all duration-300 bg-white/40 w-1.5" data-index="{{ $index }}"></div>
                    @endforeach
                </div>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const track = document.getElementById('carousel-track');
                const slides = Array.from(track.children);
                const nextBtn = document.getElementById('nextBtn');
                const prevBtn = document.getElementById('prevBtn');
                const dots = Array.from(document.querySelectorAll('.carousel-dot'));
                
                if (!nextBtn || slides.length <= 1) return;

                let currentIndex = 0;
                let autoSlideInterval;

                const updateCarousel = (index) => {
                    currentIndex = index;
                    track.style.transform = `translateX(-${currentIndex * 100}%)`;
                    
                    // Update dots
                    dots.forEach((dot, i) => {
                        if (i === currentIndex) {
                            dot.classList.add('bg-white', 'w-6');
                            dot.classList.remove('bg-white/40', 'w-1.5');
                        } else {
                            dot.classList.remove('bg-white', 'w-6');
                            dot.classList.add('bg-white/40', 'w-1.5');
                        }
                    });
                };

                const startAutoSlide = () => {
                    stopAutoSlide();
                    autoSlideInterval = setInterval(() => {
                        let next = (currentIndex + 1) % slides.length;
                        updateCarousel(next);
                    }, 5000);
                };

                const stopAutoSlide = () => {
                    if (autoSlideInterval) clearInterval(autoSlideInterval);
                };

                // Initial state
                updateCarousel(0);
                startAutoSlide();

                nextBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    let next = (currentIndex + 1) % slides.length;
                    updateCarousel(next);
                    startAutoSlide(); // Reset timer on manual click
                });

                prevBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    let prev = (currentIndex - 1 + slides.length) % slides.length;
                    updateCarousel(prev);
                    startAutoSlide(); // Reset timer on manual click
                });

                // Dot navigation
                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        updateCarousel(i);
                        startAutoSlide();
                    });
                });

                // Stop auto slide on hover
                const carousel = document.getElementById('hot-news-carousel');
                carousel.addEventListener('mouseenter', stopAutoSlide);
                carousel.addEventListener('mouseleave', startAutoSlide);
            });
        </script>
    @endif

    <div class="flex justify-between items-center mb-10 border-b pb-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">
                {{ $featuredNews ? 'Tin tức khác' : 'Tin mới nhất' }}
            </h1>
            <p class="text-gray-500 mt-1">Cập nhật những thông tin mới nhất trong ngày</p>
        </div>
        @auth
            <a href="{{ route('news.create') }}" class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Viết bài
            </a>
        @endauth
    </div>

    {{-- Search/Filter Section --}}
    <div class="mb-12 bg-gray-100 p-6 rounded-2xl">
        <form action="{{ route('news.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow relative">
                <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}" 
                    class="w-full pl-10 pr-4 py-3 rounded-xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-500 shadow-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-3.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            
            <div class="md:w-64">
                <select name="category" class="w-full py-3 px-4 rounded-xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-500 shadow-sm transition-all appearance-none cursor-pointer bg-white">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                    <option value="uncategorized" {{ request('category') == 'uncategorized' ? 'selected' : '' }}>Chưa phân loại</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all">
                Lọc tin
            </button>
        </form>
        
        @if(request('search') || request('category') || request('tag'))
            <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Kết quả lọc: <span class="font-bold text-gray-900">{{ $news->total() }} bài viết</span>
                </div>
                <a href="{{ route('news.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Xóa bộ lọc
                </a>
            </div>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row gap-12">
        <div class="lg:w-2/3">
            @if($news->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-dashed border-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v4a2 2 0 002 2h4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 13h10" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17h10" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 9h5" />
                    </svg>
                    <p class="text-gray-500 text-lg">Hiện tại chưa có bài viết nào phù hợp.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($news as $item)
                        <div class="group bg-white overflow-hidden rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col">
                            <div class="relative overflow-hidden aspect-video">
                                @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-blue-50 flex items-center justify-center text-blue-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                @if($item->is_hot)
                                    <span class="absolute top-4 left-4 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase">HOT</span>
                                @endif
                                @if($item->category)
                                    <a href="{{ route('news.index', ['category' => $item->category->id]) }}" class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm text-gray-900 text-[10px] font-bold px-2 py-1 rounded">
                                        {{ $item->category->name }}
                                    </a>
                                @endif
                            </div>
                            
                            <div class="p-6 flex-grow">
                                <div class="flex items-center text-gray-400 text-xs mb-3 space-x-2">
                                    <span>{{ $item->user->name ?? 'User' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $item->created_at->format('M d, Y') }}</span>
                                    <span>&bull;</span>
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ number_format($item->views) }}
                                    </span>
                                </div>
                                
                                <h2 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors line-clamp-2 leading-tight">
                                    <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                                </h2>
                                
                                <p class="text-gray-500 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($item->content), 120) }}
                                </p>
                            </div>
                            
                            <div class="px-6 py-4 border-t border-gray-50 flex justify-between items-center">
                                <a href="{{ route('news.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center group/btn">
                                    Xem thêm 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover/btn:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                
                                @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $item->user_id))
                                    <div class="flex space-x-3">
                                        <a href="{{ route('news.edit', $item->id) }}" class="text-gray-400 hover:text-yellow-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v3m4 3H9" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $news->links() }}
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:w-1/3">
            @include('partials.trending_news')
        </div>
    </div>
@endsection
