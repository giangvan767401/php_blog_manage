@extends('layouts.myapp')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-7xl">
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
        <div>
            <a href="{{ route('news.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Quay lại trang chủ
            </a>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Quản lý bài viết</h1>
            <p class="text-gray-500 mt-1">Hệ thống phê duyệt và phân loại tin tức hệ thống.</p>
        </div>

        <div class="flex bg-gray-200/50 p-1.5 rounded-2xl backdrop-blur-sm border border-gray-200">
            <a href="{{ route('admin.news.index') }}" 
               class="px-8 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('admin.news.index') ? 'bg-white text-blue-600 shadow-md ring-1 ring-black/5' : 'text-gray-600 hover:bg-white/50' }}">
                Chờ duyệt
            </a>
            <a href="{{ route('admin.news.approved') }}" 
               class="px-8 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('admin.news.approved') ? 'bg-white text-blue-600 shadow-md ring-1 ring-black/5' : 'text-gray-600 hover:bg-white/50' }}">
                Đã duyệt
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center p-4 mb-6 text-green-800 rounded-2xl bg-green-50 border border-green-100 shadow-sm animate-fade-in-down">
            <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Thông tin bài viết</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">Tin nóng</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">Trạng thái</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($news as $item)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors leading-tight mb-1">
                                    {{ $item->title }}
                                </span>
                                <div class="flex items-center gap-3 text-xs text-gray-400">
                                    <span class="flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>{{ $item->user->name ?? 'N/A' }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $item->category->name ?? 'Không xác định' }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>{{ $item->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-center">
                            @if($item->status === 'approved')
                                <form action="{{ route('admin.news.toggle-hot', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" title="Bật/Tắt tin nóng" class="p-2 rounded-xl transition-all {{ $item->is_hot ? 'bg-orange-100 text-orange-600 ring-1 ring-orange-200' : 'bg-gray-50 text-gray-300 hover:text-gray-400' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ $item->is_hot ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.99 7.99 0 0121 13a8.144 8.144 0 01-.121 1.403l-.004.02a8.035 8.035 0 01-.69 1.93l-.02.046c-.235.533-.53 1.036-.88 1.503l-.01.015a8.006 8.006 0 01-1.618 1.743z" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <span class="text-xs italic text-gray-300">Chờ duyệt...</span>
                            @endif
                        </td>

                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset 
                                {{ $item->status === 'approved' ? 'bg-green-50 text-green-700 ring-green-600/20' : 
                                   ($item->status === 'rejected' ? 'bg-red-50 text-red-700 ring-red-600/20' : 
                                   ($item->status === 'resubmitted' ? 'bg-blue-50 text-blue-700 ring-blue-600/20' : 'bg-yellow-50 text-yellow-700 ring-yellow-600/20')) }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $item->status === 'approved' ? 'bg-green-600' : ($item->status === 'rejected' ? 'bg-red-600' : 'bg-yellow-500') }}"></span>
                                {{ $item->status === 'pending' ? 'Chờ duyệt' : 
                                   ($item->status === 'approved' ? 'Đã duyệt' : 
                                   ($item->status === 'resubmitted' ? 'Cập nhật' : 'Từ chối')) }}
                            </span>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex flex-col items-end gap-3">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('news.show', $item->id) }}" class="text-sm font-bold text-blue-600 hover:underline" target="_blank text-gray-400 hover:text-blue-600 transition-colors">Xem bài</a>
                                    
                                    @if($item->status !== 'approved')
                                        <form action="{{ route('admin.news.approve', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-sm font-bold text-green-600 hover:text-green-700">Duyệt nhanh</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa vĩnh viễn?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors">Xóa</button>
                                    </form>
                                </div>

                                @if($item->status !== 'approved')
                                    <form action="{{ route('admin.news.reject', $item->id) }}" method="POST" class="flex gap-2 group/reject">
                                        @csrf
                                        <input type="text" name="admin_note" placeholder="Lý do từ chối..." required
                                            class="text-xs bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-400 outline-none w-48 transition-all">
                                        <button type="submit" class="bg-white border border-red-200 text-red-600 hover:bg-red-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                            Từ chối
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-100 p-4 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium">Hiện tại không có bài viết nào cần xử lý.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 shadow-sm">
        {{ $news->links() }}
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.4s ease-out; }
</style>
@endsection