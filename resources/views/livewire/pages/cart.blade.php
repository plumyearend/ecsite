<div>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="max-w-2xl text-center mx-auto">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-black">ショッピングカート</h2>
        </div>
    </div>

    <form method="POST" action="{{ route('cart.checkout') }}">
        @csrf
        @if ($list->isEmpty())
            <p class="text-center">カートには何も入っていません</p>
        @else
            @foreach ($list as $item)
                <div class="flex items-center mb-4 p-4 bg-white shadow rounded-lg">
                    <div class="w-32 h-32">
                        <img src="{{ \Storage::url($item['product']->productImages[0]->image) }}"
                            alt="{{ $item['product']->name }}" class="w-full h-full object-cover rounded">
                    </div>
                    <div class="ml-6 flex-1">
                        <h3 class="text-xl font-semibold">{{ $item['product']->name }}</h3>
                        <p class="text-gray-500 text-lg">¥{{ number_format($item['product']->price) }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button wire:click="decreaseCount({{ $item['product']->id }})"
                            class="px-3 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
                            @if ($item['count'] <= 1) disabled @endif>-</button>
                        <span class="text-lg">{{ $item['count'] }}</span>
                        <button wire:click="increaseCount({{ $item['product']->id }})"
                            class="px-3 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
                            @if ($item['count'] >= 5) disabled @endif>+</button>

                        <button wire:click="removeItem({{ $item['product']->id }})"
                            class="ml-4 text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="mt-6">
            <h3 class="text-xl font-semibold">小計（税込）: ¥{{ number_format($totalPrice) }}</h3>
        </div>

        <div class="mt-6">
            @auth
                <div class="mt-3 flex">
                    <a href="{{ route('top') }}"
                        class="w-full px-6 py-3 bg-blue-600 text-center text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        買い物を続ける
                    </a>

                    <button
                        class="w-full ml-3 px-6 py-3 bg-blue-600 text-center text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        ご購入手続きへ進む
                    </button>
                </div>
            @else
                <p class="text-center">
                    商品購入を行うにはログインが必要です。
                </p>
                <div class="mt-3 flex">
                    <button wire:click="redirectToLogin"
                        class="w-full px-6 py-3 bg-blue-600 text-center text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        ログイン
                    </button>

                    <button wire:click="redirectToSignup"
                        class="w-full ml-3 px-6 py-3 bg-blue-600 text-center text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        マイページ登録
                    </button>
                </div>
            @endauth
        </div>
    </form>
</div>
