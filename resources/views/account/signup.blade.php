<x-guest-layout>
    <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-gray-800">新規登録</h1>
                <p class="mt-2 text-sm text-gray-600">
                    すでにアカウントをお持ちですか?
                    <a class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium"
                        href="{{ route('account.login')}}">
                        こちらからサインインしてください
                    </a>
                </p>
            </div>

            <div class="mt-5">
                <a href="{{ route('auth.github') }}" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                    GitHubアカウントで登録
                </a>

                <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
                    または
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('account.register')}}">
                    @csrf
                    <div class="grid gap-y-4">
                        <!-- Form Group -->
                        <div>
                            <label for="email" class="block text-sm mb-2">メールアドレス</label>
                            <div class="relative">
                                <input type="email" id="email" name="email"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="email-error"
                                    value="{{ old('email')}} "
                                >
                                @error('email')
                                <x-error-icon />
                                @enderror
                            </div>
                            @error('email')
                            <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End Form Group -->

                        <!-- Checkbox -->
                        <div class="flex items-center">
                            <div class="flex">
                                <input id="accepts" name="accepts" type="checkbox"
                                    class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500"
                                    value="1"
                                >
                            </div>
                            <div class="ms-3">
                                <label for="accepts" class="text-sm">
                                    利用規約およびプライバシーポリシーの内容に同意しました。
                                </label>
                            </div>
                        </div>
                        @error('accepts')
                        <p class="text-xs text-red-600" id="accepts-error">{{ $message }}</p>
                        @enderror
                        <!-- End Checkbox -->

                        <button type="submit"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            登録する
                        </button>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</x-guest-layout>
