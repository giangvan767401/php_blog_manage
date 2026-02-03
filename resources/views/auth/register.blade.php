<x-guest-layout>
    <div class="min-h-[600px] flex flex-col justify-center">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tạo tài khoản mới</h2>
            <p class="text-gray-500 mt-2">Bắt đầu hành trình của bạn với chúng tôi ngay hôm nay</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="group">
                <x-input-label for="name" :value="__('Họ và tên')" class="group-focus-within:text-indigo-600 transition-colors" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <x-text-input id="name" 
                        class="block w-full pl-10 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all" 
                        type="text" name="name" :value="old('name')" 
                        required autofocus autocomplete="name" 
                        placeholder="Nguyễn Văn A" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="group">
                <x-input-label for="email" :value="__('Email')" class="group-focus-within:text-indigo-600 transition-colors" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <x-text-input id="email" 
                        class="block w-full pl-10 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all" 
                        type="email" name="email" :value="old('email')" 
                        required autocomplete="username" 
                        placeholder="email@example.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="group">
                <x-input-label for="password" :value="__('Mật khẩu')" class="group-focus-within:text-indigo-600 transition-colors" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <x-text-input id="password" 
                        class="block w-full pl-10 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all"
                        type="password"
                        name="password"
                        required autocomplete="new-password"
                        placeholder="Tối thiểu 8 ký tự" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="group">
                <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" class="group-focus-within:text-indigo-600 transition-colors" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <x-text-input id="password_confirmation" 
                        class="block w-full pl-10 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all"
                        type="password"
                        name="password_confirmation" 
                        required autocomplete="new-password"
                        placeholder="Nhập lại mật khẩu" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all active:scale-[0.98]">
                    {{ __('Đăng ký ngay') }}
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    {{ __('Đã có tài khoản?') }} 
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500 hover:underline transition-colors">
                        {{ __('Đăng nhập tại đây') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>