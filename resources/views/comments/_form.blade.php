<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-10 transition-all focus-within:shadow-md">
    <div class="p-6 sm:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2.5 bg-blue-50 rounded-xl">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 italic">Viết bình luận của bạn</h3>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl animate-fade-in">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold text-red-800 text-sm italic">Đã xảy ra lỗi:</span>
                </div>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-1 ml-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('news.comments.store', $news->id) }}" method="POST" class="space-y-5">
            @csrf

            <div class="group">
                <label for="title" class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                    Tiêu đề <span class="text-xs font-normal text-gray-400 italic">(không bắt buộc)</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    placeholder="Tóm tắt ý kiến của bạn..."
                    class="w-full px-5 py-3 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none shadow-sm text-sm" 
                    value="{{ old('title') }}" 
                >
            </div>

            <div class="group">
                <label for="content" class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                    Nội dung bình luận <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="4" 
                    placeholder="Chia sẻ suy nghĩ của bạn về bài viết này..."
                    class="w-full px-5 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none shadow-sm text-sm resize-none" 
                >{{ old('content') }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold rounded-2xl shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:-translate-y-0.5 transition-all active:scale-[0.98]">
                    <span>Gửi bình luận ngay</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>