<x-guest-layout>
    <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-gray-800">ログイン</h1>
                <p class="mt-2 text-sm text-gray-600">
                    まだアカウントをお持ちではありませんか？
                    <a class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium"
                        href="{{ route('account.signup') }}">
                        こちらからサインアップしてください
                    </a>
                </p>
            </div>

            <div class="mt-5">
                <a href="{{ route('auth.github') }}"
                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                    GitHubでログイン
                </a>

                <div
                    class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
                    または</div>

                <!-- Form -->
                <form method="POST" action="{{ route('account.authenticate') }}">
                    @csrf
                    <div class="grid gap-y-4">
                        @if (session()->has('login_error'))
                            <p class="text-xs text-red-600 mt-2">{{ session('login_error') }}</p>
                        @endif
                        <!-- Form Group -->
                        <div>
                            <label for="email" class="block text-sm mb-2">メールアドレス</label>
                            <div class="relative">
                                <input type="email" id="email" name="email"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="email-error" value="{{ old('email') }}">
                                @error('email')
                                    <x-error-icon />
                                @enderror
                            </div>
                            @error('email')
                                <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div>
                            <div class="flex justify-between items-center">
                                <label for="password" class="block text-sm mb-2">パスワード</label>
                            </div>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="password-error" value="{{ old('password') }}">
                                @error('password')
                                    <x-error-icon />
                                @enderror
                            </div>
                            @error('password')
                                <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End Form Group -->

                        <button type="submit"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">ログイン</button>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</x-guest-layout>
