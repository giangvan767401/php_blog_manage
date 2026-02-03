<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                        Laravel News
                    </a>
                </div>

            </div>
            <div class="flex items-center">
                @if(Route::has('login'))
                    @auth
                        <div class="ml-3 relative flex items-center space-x-4">
                            <a href="{{ route('news.my') }}" class="text-sm text-gray-700 hover:text-gray-900 underline">Bài viết của tôi</a>
                            
                            {{-- Notification Bell --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </button>

                                <div x-show="open" @click.away="open = false" 
                                    class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100">
                                    <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                                        <h3 class="font-bold text-gray-900">Thông báo</h3>
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-blue-600 hover:underline">Đánh dấu tất cả đã đọc</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @forelse(auth()->user()->notifications->take(10) as $notification)
                                            <a href="{{ route('notifications.mark-as-read', $notification->id) }}" 
                                               class="block p-4 border-b hover:bg-blue-50 transition-colors {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50/30' }}">
                                                <div class="text-sm font-bold text-gray-900">{{ $notification->data['title'] ?? 'Thông báo mới' }}</div>
                                                <div class="text-xs text-gray-600 mt-1">{{ $notification->data['message'] }}</div>
                                                <div class="text-[10px] text-gray-400 mt-2 tracking-tighter">{{ $notification->created_at->diffForHumans() }}</div>
                                            </a>
                                        @empty
                                            <div class="p-8 text-center text-gray-400 text-sm">Không có thông báo nào</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <span class="text-gray-700 text-sm">Hello, {{ Auth::user()->name }}</span>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.writer.requests') }}" class="text-sm text-green-600 hover:text-green-900 border border-green-600 px-3 py-1 rounded">Yêu cầu Writer</a>
                                <a href="{{ route('admin.news.index') }}" class="text-sm text-blue-600 hover:text-blue-900 border border-blue-600 px-3 py-1 rounded">Duyệt bài</a>
                                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 border border-gray-600 px-3 py-1 rounded">Admin Dashboard</a>
                            @elseif(Auth::user()->canRequestWriter())
                                <form action="{{ route('writer.request') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900 border border-indigo-600 px-3 py-1 rounded">Đăng ký làm người viết</button>
                                </form>
                            @elseif(Auth::user()->hasPendingWriterRequest())
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded italic font-medium">Đang chờ duyệt Writer...</span>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">
                                    {{ __('Log out') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</header>