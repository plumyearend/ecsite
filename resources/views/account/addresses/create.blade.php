<x-app-layout>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="max-w-2xl text-center mx-auto mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-black">新しいお届け先を追加</h2>
        </div>

        <div class="mt-5">
            <!-- Form -->
            <form method="POST" action="{{ route('account.addresses.store')}}">
                @csrf
                <div class="grid gap-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label for="last_name" class="block text-sm mb-2">名前（姓）</label>
                            <div class="relative">
                                <input type="text" id="last_name" name="last_name"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required
                                    aria-describedby="last_name-error"
                                    placeholder="姓"
                                    value="{{ old('last_name') }}"
                                >
                                @error('last_name')
                                <x-error-icon />
                                <p class="text-xs text-red-600 mt-2" id="last_name-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="first_name" class="block text-sm mb-2">名前（名）</label>
                            <div class="relative">
                                <input type="text" id="first_name" name="first_name"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required
                                    aria-describedby="first_name-error"
                                    placeholder="名"
                                    value="{{ old('first_name') }}"
                                >
                                @error('first_name')
                                <x-error-icon />
                                <p class="text-xs text-red-600 mt-2" id="first_name-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <label for="postcode" class="block text-sm mb-2">郵便番号</label>
                        </div>
                        <div class="relative">
                            <input type="number" id="postcode" name="postcode"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                required
                                aria-describedby="postcode-error"
                                value="{{ old('postcode') }}"
                            >
                            @error('postcode')
                            <x-error-icon />
                            @enderror
                        </div>
                        @error('postcode')
                        <p class="text-xs text-red-600 mt-2" id="postcode-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <label for="prefecture_id" class="block text-sm mb-2">都道府県</label>
                        </div>
                        <div class="relative">
                            <select
                                id="prefecture_id" name="prefecture_id"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                required
                                aria-describedby="prefecture_id-error"
                            >
                                @foreach ($prefectures as $prefecture)
                                <option value="{{ $prefecture->id }}" @if (old('prefecture_id')) selecte @endif>{{ $prefecture->name }}</option>
                                @endforeach
                            </select>
                            @error('prefecture_id')
                            <x-error-icon />
                            @enderror
                        </div>
                        @error('prefecture_id')
                        <p class="text-xs text-red-600 mt-2" id="prefecture_id-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <label for="address1" class="block text-sm mb-2">市区町村</label>
                        </div>
                        <div class="relative">
                            <input type="text" id="address1" name="address1"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                required
                                aria-describedby="address1-error"
                                value="{{ old('address1') }}"
                            >
                            @error('address1')
                            <x-error-icon />
                            @enderror
                        </div>
                        @error('address1')
                        <p class="text-xs text-red-600 mt-2" id="address1-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <label for="address2" class="block text-sm mb-2">地名・番地</label>
                        </div>
                        <div class="relative">
                            <input type="text" id="address2" name="address2"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                aria-describedby="address2-error"
                                value="{{ old('address2') }}"
                            >
                            @error('address2')
                            <x-error-icon />
                            @enderror
                        </div>
                        @error('address2')
                        <p class="text-xs text-red-600 mt-2" id="address2-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <label for="address3" class="block text-sm mb-2">建物名・部屋番号</label>
                        </div>
                        <div class="relative">
                            <input type="text" id="address3" name="address3"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                aria-describedby="address3-error"
                                value="{{ old('address3') }}"
                            >
                            @error('address3')
                            <x-error-icon />
                            @enderror
                        </div>
                        @error('address3')
                        <p class="text-xs text-red-600 mt-2" id="address3-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <label for="tel" class="block text-sm mb-2">電話番号</label>
                        </div>
                        <div class="relative">
                            <input type="number" id="tel" name="tel"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                required
                                aria-describedby="tel-error"
                                placeholder="09012345678（ハイフンなし）"
                                value="{{ old('tel') }}"
                            >
                            @error('tel')
                            <x-error-icon />
                            @enderror
                        </div>
                        @error('tel')
                        <p class="text-xs text-red-600 mt-2" id="tel-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <div class="flex">
                            <input id="is_default_adress" name="is_default_adress" type="checkbox"
                                class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500"
                                value="1"
                                @if (old('is_default_adress'))checked @endif
                            >
                        </div>
                        <div class="ms-3">
                            <label for="is_default_adress" class="text-sm">
                                この住所を既定のお届け先にする
                            </label>
                        </div>
                    </div>
                    @error('is_default_adress')
                    <p class="text-xs text-red-600" id="is_default_adress-error">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">ログイン</button>
                </div>
            </form>
            <!-- End Form -->
        </div>
    </div>
</x-app-layout>
