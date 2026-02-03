@extends('layouts.myapp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Quản lý người viết bài (Writer)</h1>
        <p class="text-gray-500 mt-1">Duyệt yêu cầu mới và quản lý danh sách người viết hiện tại.</p>
    </div>

    {{-- Section 1: Pending Requests --}}
    <div class="mb-12">
        <div class="flex items-center space-x-3 mb-6">
            <div class="h-8 w-1 bg-yellow-500 rounded-full"></div>
            <h2 class="text-xl font-bold text-gray-800">Yêu cầu đang chờ duyệt ({{ $pendingWriters->count() }})</h2>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Người dùng</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Ngày yêu cầu</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($pendingWriters as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-700 font-bold text-xs mr-3">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-400">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <form action="{{ route('admin.writer.approve', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-black hover:bg-gray-800 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition-all duration-200">
                                    Duyệt
                                </button>
                            </form>
                            <form action="{{ route('admin.writer.reject', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-white hover:bg-gray-50 text-red-600 text-xs font-bold py-2 px-4 rounded-lg border border-gray-200 transition-all duration-200" onclick="return confirm('Từ chối yêu cầu này?')">
                                    Từ chối
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-400 text-sm">Hiện không có yêu cầu nào đang chờ.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Section 2: Active Writers --}}
    <div>
        <div class="flex items-center space-x-3 mb-6">
            <div class="h-8 w-1 bg-blue-500 rounded-full"></div>
            <h2 class="text-xl font-bold text-gray-800">Danh sách Writer hiện tại ({{ $activeWriters->count() }})</h2>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Người dùng</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Ngày tham gia</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($activeWriters as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs mr-3">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-400">{{ $user->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <form action="{{ route('admin.writers.demote', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Gỡ quyền Writer của người dùng này?')">
                                @csrf
                                <button type="submit" class="text-red-600 hover:bg-red-50 text-xs font-black px-4 py-2 rounded-lg border border-red-100 transition-all duration-200">
                                    Gỡ quyền
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 text-sm">Không tìm thấy người viết nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
