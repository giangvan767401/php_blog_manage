<x-guest-layout>
    <div class="min-h-[500px] flex flex-col justify-center">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Chào mừng trở lại!</h2>
            <p class="text-gray-500 mt-2">Vui lòng đăng nhập vào tài khoản của bạn</p>
        </div>

        <x-auth-session-status class="mb-4 text-center font-medium" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="group">
                <x-input-label for="email" :value="__('Email')" class="group-focus-within:text-blue-600 transition-colors" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" /></svg>
                    </div>
                    <x-text-input id="email" 
                        class="block w-full pl-10 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all" 
                        type="email" name="email" :value="old('email')" 
                        required autofocus autocomplete="username" 
                        placeholder="example@gmail.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="group">
                <div class="flex justify-between items-center">
                    <x-input-label for="password" :value="__('Mật khẩu')" class="group-focus-within:text-blue-600 transition-colors" />
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors" href="{{ route('password.request') }}">
                            {{ __('Quên mật khẩu?') }}
                        </a>
                    @endif
                </div>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <x-text-input id="password" 
                        class="block w-full pl-10 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all"
                        type="password"
                        name="password"
                        required autocomplete="current-password"
                        placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer transition-all" name="remember">
                    <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Ghi nhớ đăng nhập') }}</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all active:scale-[0.98]">
                    {{ __('Đăng nhập ngay') }}
                </button>
            </div>
            
            <div class="text-center text-sm text-gray-500 mt-6">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Đăng ký miễn phí</a>
            </div>
        </form>
    </div>
</x-guest-layout>