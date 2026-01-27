<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-8">
    <div class="bg-gradient-to-r from-red-600 to-orange-500 p-4">
        <h3 class="text-lg font-black text-white flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            Trending Tuần
        </h3>
    </div>
    
    <div class="divide-y divide-gray-100">
        @forelse($trendingNews as $index => $item)
            <a href="{{ route('news.show', $item->id) }}" class="group block p-4 hover:bg-blue-50/50 transition-colors">
                <div class="flex items-start space-x-4">
                    <span class="text-2xl font-black text-gray-200 group-hover:text-blue-200 transition-colors leading-none">
                        {{ $index + 1 }}
                    </span>
                    <div class="flex-grow">
                        <div class="text-[10px] font-bold text-blue-600 uppercase mb-1 flex items-center">
                            {{ $item->category->name ?? 'News' }}
                            <span class="mx-1">&bull;</span>
                            <span class="flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ number_format($item->views) }}
                            </span>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-blue-700 transition-colors line-clamp-2 leading-snug">
                            {{ $item->title }}
                        </h4>
                    </div>
                </div>
            </a>
        @empty
            <p class="p-8 text-center text-gray-400 text-sm italic">Chưa có bài viết xu hướng.</p>
        @endforelse
    </div>
</div>
