<x-guest-layout>
    <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-gray-800">アカウントを有効化する</h1>
            </div>

            <div class="mt-5">
                <!-- Form -->
                <form method="POST" action="{{ route('account.activate.store')}}">
                    @csrf
                    <div class="grid gap-y-4">
                        <div>
                            <label for="name" class="block text-sm mb-2">名前</label>
                            <div class="relative">
                                <input type="text" id="name" name="name"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required
                                    aria-describedby="name-error"
                                    value="{{ old('name') }}"
                                >
                                @error('name')
                                <x-error-icon />
                                @enderror
                            </div>
                            @error('name')
                            <p class="text-xs text-red-600 mt-2" id="name-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex justify-between items-center">
                                <label for="password" class="block text-sm mb-2">パスワード</label>
                            </div>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required
                                    aria-describedby="password-error"
                                >
                                @error('password')
                                <x-error-icon />
                                @enderror
                            </div>
                            @error('password')
                            <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex justify-between items-center">
                                <label for="password_confirmation" class="block text-sm mb-2">パスワード（確認）</label>
                            </div>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required
                                    aria-describedby="password_confirmation-error"
                                >
                                @error('password_confirmation')
                                <x-error-icon />
                                @enderror
                            </div>
                            @error('password_confirmation')
                            <p class="text-xs text-red-600 mt-2" id="password_confirmation-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" id="email" name="email" value="{{ $email }}" />

                        <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">ログイン</button>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</x-guest-layout>
