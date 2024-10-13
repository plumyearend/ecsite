<div>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="container mx-auto py-8">
            <div class="flex flex-col lg:flex-row">
                <div class="lg:w-1/2">
                    <div class="mb-4">
                        <img id="mainImage" src="{{ \Storage::url($selectImage->image) }}" alt="{{ $product->name }}"
                            class="w-full h-auto rounded-lg shadow-md">
                    </div>

                    <div class="flex space-x-4 overflow-x-auto">
                        @foreach ($product->productImages as $productImage)
                            <img src="{{ \Storage::url($productImage->image) }}" alt="{{ $product->name }}"
                                class="w-24 h-24 object-cover rounded-lg cursor-pointer hover:opacity-75"
                                wire:click="changeImage({{ $productImage }})">
                        @endforeach
                    </div>
                </div>

                <div class="lg:w-1/2 lg:pl-8 mt-6 lg:mt-0">
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                    <div class="text-2xl font-semibold text-gray-900 mb-4">
                        ¥{{ $product->price }}
                    </div>
                    <p class="text-lg text-gray-700 mb-4">
                        {!! nl2br($product->description) !!}
                    </p>

                    <div class="flex items-center mb-6">
                        <label for="quantity" class="mr-4 text-lg font-medium">数量:</label>
                        <input type="number" wire:model="quantity" value="1" min="1"
                            max="{{ $product->count_max < 5 ? $product->count_max : 5 }}"
                            class="w-16 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button wire:click="add"
                        class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        購入する
                    </button>

                    @if ($isShowModal)
                        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded-lg shadow-lg">
                                <h2 class="text-xl font-bold mb-4">カートに商品が追加されました！</h2>
                                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    <a href="{{ route('cart') }}">
                                        カートへ進む
                                    </a>
                                </button>
                                <button wire:click="closeModal"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    お買い物を続ける
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
