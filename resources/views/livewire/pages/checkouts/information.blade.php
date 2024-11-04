<div>
    <div class="mt-10 w-full mx-auto p-6 bg-white shadow-md rounded-lg flex gap-8">

        <div class="w-full lg:w-1/2">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">お送り先住所</h2>

            <div class="mb-6">
                <label for="address_select" class="block text-sm font-medium text-gray-700 mb-2">登録済みの住所から選択</label>
                <select id="address_select" name="address_select" wire:model="selectAddressId" wire:change="setAddress"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    @foreach ($addresses as $address)
                        <option value="{{ $address->id }}" @if ($selectAddressId === $address->id) selected @endif>
                            {{ $address->postcode }} {{ $address->address1 }} {{ $address->address2 }}
                        </option>
                    @endforeach
                </select>
            </div>

            <hr class="my-6 border-gray-300" />

            <form action="" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="postcode" class="block text-sm font-medium text-gray-700 mb-1">郵便番号</label>
                    <input type="text" name="postcode" id="postcode" wire:model="postcode"
                        value="{{ old('postcode') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                        placeholder="例: 123-4567" required>
                    @error('postcode')
                        <p class="text-xs text-red-600 mt-2" id="postcode-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="prefecture_id" class="block text-sm font-medium text-gray-700 mb-1">都道府県</label>
                    <select id="prefecture_id" name="prefecture_id" wire:model="prefecture_id"
                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        required aria-describedby="prefecture_id-error">
                        @foreach ($prefectures as $key => $prefecture)
                            <option value="{{ $key }}" @if (old('prefecture_id', $address?->prefecture_id)) selecte @endif>
                                {{ $prefecture }}</option>
                        @endforeach
                    </select>
                    @error('prefecture_id')
                        <p class="text-xs text-red-600 mt-2" id="prefecture_id-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address1" class="block text-sm font-medium text-gray-700 mb-1">市区町村</label>
                    <input type="text" name="address1" id="address1" wire:model="address1"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                        placeholder="例: 渋谷区" required>
                    @error('address1')
                        <p class="text-xs text-red-600 mt-2" id="address1-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address2" class="block text-sm font-medium text-gray-700 mb-1">地名・番地</label>
                    <input type="text" name="address2" id="address2" wire:model="address2"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary"
                        placeholder="例: 1-2-3" required>
                    @error('address2')
                        <p class="text-xs text-red-600 mt-2" id="address2-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address3" class="block text-sm font-medium text-gray-700 mb-1">ビル名・マンション名</label>
                    <input type="text" name="address3" id="address3" wire:model="address3"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary"
                        placeholder="例: マンション101">
                    @error('address3')
                        <p class="text-xs text-red-600 mt-2" id="address3-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tel" class="block text-sm font-medium text-gray-700 mb-1">電話番号</label>
                    <input type="text" name="tel" id="tel" wire:model="tel"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary"
                        placeholder="000-0000-0000">
                    @error('tel')
                        <p class="text-xs text-red-600 mt-2" id="tel-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="mt-5 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        住所を保存して次へ
                    </button>
                </div>
            </form>
        </div>

        <div class="w-full lg:w-1/2">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">注文内容の確認</h2>

            <div class="space-y-4">
                @foreach ($orderDetails as $orderDetail)
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                        <img src="{{ \Storage::url($orderDetail->product->mainProductImage->image) }}"
                            alt="{{ $orderDetail->product->name }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $orderDetail->product->name }} × {{ $orderDetail->count }}
                            </h3>
                            <p class="text-gray-600">{{ number_format($orderDetail->price_tax) }} 円</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 border-t pt-4">
                <p class="text-lg font-semibold text-gray-700">合計金額: {{ number_format($order->total_price) }} 円</p>
            </div>
        </div>
    </div>
</div>
