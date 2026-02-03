<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            <h2 class="font-extrabold text-2xl text-gray-800 leading-tight">
                {{ __('Thêm danh mục mới') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('categories.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 mb-6 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Quay lại danh sách
            </a>

            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-3xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="group">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                                Tên danh mục <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" 
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none shadow-sm"
                                placeholder="Ví dụ: Công nghệ, Đời sống..."
                                value="{{ old('name') }}" required>
                            
                            @error('name')
                                <div class="flex items-center mt-2 text-red-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <p class="text-xs font-semibold italic">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                                Mô tả danh mục
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none shadow-sm resize-none"
                                placeholder="Viết một vài dòng giới thiệu về danh mục này...">{{ old('description') }}</textarea>
                            
                            @error('description')
                                <div class="flex items-center mt-2 text-red-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <p class="text-xs font-semibold italic">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <hr class="border-gray-100 my-8">

                        <div class="flex items-center justify-between gap-4">
                            <a href="{{ route('categories.index') }}" 
                               class="flex-1 text-center px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 hover:text-gray-900 transition-all active:scale-[0.98]">
                                Hủy bỏ
                            </a>
                            
                            <button type="submit" 
                                class="flex-[2] px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:-translate-y-0.5 transition-all active:scale-[0.98]">
                                Tạo danh mục ngay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-6 p-4 rounded-2xl bg-blue-50 border border-blue-100 flex items-start gap-3">
                <div class="p-2 bg-blue-500 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-blue-800">Mẹo nhỏ:</h4>
                    <p class="text-sm text-blue-600">Việc mô tả danh mục rõ ràng giúp người viết (Writers) dễ dàng phân loại bài viết chính xác hơn.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>