@if($comments->count())
    <div class="flex items-center justify-between mb-8">
        <h4 class="text-2xl font-extrabold text-gray-900 tracking-tight flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
            </svg>
            Bình luận <span class="ml-2 px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">{{ $comments->total() }}</span>
        </h4>
    </div>
    
    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-gray-200 before:via-gray-100 before:to-transparent">
        @foreach($comments as $comment)
            <div class="relative pl-12 group transition-all duration-300">
                <div class="absolute left-0 top-2 flex items-center justify-center">
                    <div class="h-10 w-10 rounded-full border-4 border-white bg-gradient-to-br from-blue-500 to-indigo-600 shadow-sm flex items-center justify-center text-white text-xs font-bold uppercase transition-transform group-hover:scale-110">
                        {{ substr($comment->author?->name ?? 'K', 0, 1) }}
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-900">{{ $comment->author?->name ?? 'Khách' }}</span>
                        </div>
                        <time class="text-xs font-medium text-gray-400 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $comment->created_at->format('d/m/Y H:i') }}
                        </time>
                    </div>
                    
                    <div class="text-gray-700 leading-relaxed text-sm bg-gray-50/50 p-4 rounded-xl border border-gray-50 group-hover:bg-white transition-colors">
                        {!! nl2br(e($comment->content)) !!}
                    </div>

                    <div class="mt-4 flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="text-xs font-bold text-gray-400 hover:text-blue-600 flex items-center transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.704a2 2 0 011.94 2.315l-.942 4.47A2 2 0 0117.766 18H9m0 0H5a2 2 0 01-2-2v-3a2 2 0 012-2h4m0 0V5a2 2 0 012-2h2a2 2 0 012 2v5m-7 8h1"></path></svg>
                            Hữu ích
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if(method_exists($comments, 'links'))
        <div class="mt-8">
            {{ $comments->links() }}
        </div>
    @endif
@else
    <div class="text-center py-12 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-sm mb-4">
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </div>
        <p class="text-gray-500 font-medium italic">Chưa có bình luận nào. Hãy là người đầu tiên nêu ý kiến!</p>
    </div>
@endif