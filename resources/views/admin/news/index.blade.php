@extends('layouts.myapp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Quản lý bài viết</h1>
        <div class="flex bg-gray-100 p-1 rounded-xl shadow-inner">
            <a href="{{ route('admin.news.index') }}" 
               class="px-6 py-2 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('admin.news.index') ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Chờ duyệt
            </a>
            <a href="{{ route('admin.news.approved') }}" 
               class="px-6 py-2 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('admin.news.approved') ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Đã duyệt
            </a>
        </div>
    </div>
        <a href="{{ route('news.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Quay lại trang chủ
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tác giả</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày gửi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tin nóng</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($news as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $item->title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $item->user->name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $item->category->name ?? 'Không xác định' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($item->status === 'approved')
                            <form action="{{ route('admin.news.toggle-hot', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center space-x-1 {{ $item->is_hot ? 'text-orange-500' : 'text-gray-300' }} hover:text-orange-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="{{ $item->is_hot ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.99 7.99 0 0121 13a8.144 8.144 0 01-.121 1.403l-.004.02a8.035 8.035 0 01-.69 1.93l-.02.046c-.235.533-.53 1.036-.88 1.503l-.01.015a8.006 8.006 0 01-1.618 1.743z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <span class="text-gray-300">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $item->status === 'approved' ? 'bg-green-100 text-green-800' : 
                               ($item->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                               ($item->status === 'resubmitted' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                            {{ $item->status === 'pending' ? 'Chờ duyệt' : 
                               ($item->status === 'approved' ? 'Đã duyệt' : 
                               ($item->status === 'resubmitted' ? 'Đã cập nhật' : 'Từ chối')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex flex-col items-end space-y-2">
                            <div class="space-x-2">
                                <a href="{{ route('news.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">Xem</a>
                                
                                @if($item->status !== 'approved')
                                    <form action="{{ route('admin.news.approve', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Duyệt</button>
                                    </form>
                                @endif

                                <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-600 hover:text-gray-900">Xóa</button>
                                </form>
                            </div>

                            {{-- Form từ chối với lý do - Chỉ hiện nếu chưa được duyệt --}}
                            @if($item->status !== 'approved')
                                <form action="{{ route('admin.news.reject', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="text" name="admin_note" placeholder="Lý do từ chối..." required
                                        class="text-xs border rounded px-2 py-1 focus:ring-1 focus:ring-red-500 outline-none w-48">
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-bold border border-red-600 px-2 py-1 rounded hover:bg-red-50">
                                        Từ chối
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Không có bài viết nào cần duyệt.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $news->links() }}
    </div>
</div>
@endsection
