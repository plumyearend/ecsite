<div>
    <div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded-lg flex gap-8">

        <div class="w-full lg:w-1/2">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">お送り先住所</h2>

            <div class="mb-6">
                <label for="address_select" class="block text-sm font-medium text-gray-700 mb-2">登録済みの住所から選択</label>
                <select id="address_select" name="address_select"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    <option value="">住所を選択してください</option>
                    {{-- TODO: 仮 --}}

                    {{-- @foreach ($savedAddresses as $address)
                    <option value="{{ $address->id }}">
                        {{ $address->postal_code }} {{ $address->city }} {{ $address->street }}
                    </option>
                @endforeach --}}
                </select>
            </div>

            <hr class="my-6 border-gray-300" />

            <h3 class="text-lg font-semibold text-gray-700 mb-4">新しい住所を入力</h3>
            <form action="" method="POST">
                @csrf
                {{-- 郵便番号 --}}
                <div class="mb-4">
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">郵便番号</label>
                    <input type="text" name="postal_code" id="postal_code"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                        placeholder="例: 123-4567" required>
                </div>

                {{-- 都道府県 --}}
                <div class="mb-4">
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">都道府県</label>
                    <input type="text" name="state" id="state"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                        placeholder="例: 東京都" required>
                </div>

                {{-- 市区町村 --}}
                <div class="mb-4">
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">市区町村</label>
                    <input type="text" name="city" id="city"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                        placeholder="例: 渋谷区" required>
                </div>

                {{-- 番地以下 --}}
                <div class="mb-4">
                    <label for="street" class="block text-sm font-medium text-gray-700 mb-1">番地以下</label>
                    <input type="text" name="street" id="street"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary sm:text-sm"
                        placeholder="例: 1-2-3" required>
                </div>

                {{-- ビル名・マンション名 --}}
                <div class="mb-4">
                    <label for="building" class="block text-sm font-medium text-gray-700 mb-1">ビル名・マンション名</label>
                    <input type="text" name="building" id="building"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary sm:text-sm"
                        placeholder="例: マンション101">
                </div>

                {{-- 保存ボタン --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-white font-semibold rounded-md shadow-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        住所を保存して次へ
                    </button>
                </div>
            </form>
        </div>

        <div class="w-full lg:w-1/2">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">注文内容の確認</h2>

            {{-- TODO: 仮 --}}
            <div class="space-y-4">
                {{-- @foreach ($cartItems as $item)
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                            class="w-16 h-16 object-cover rounded-lg mr-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $item->name }}</h3>
                            <p class="text-gray-600">{{ number_format($item->price) }} 円</p>
                        </div>
                    </div>
                @endforeach --}}
            </div>

            <div class="mt-6 border-t pt-4">
                <p class="text-lg font-semibold text-gray-700">合計金額: {{ number_format($order->total_price) }} 円</p>
            </div>
        </div>
    </div>
</div>
