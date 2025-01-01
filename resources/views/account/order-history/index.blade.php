<x-app-layout>
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-6">注文履歴</h1>
        @if ($orders->isEmpty())
            <p class="text-gray-500">注文履歴がありません。</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b">注文日</th>
                            <th class="px-4 py-2 border-b">合計金額</th>
                            <th class="px-4 py-2 border-b">ステータス</th>
                            <th class="px-4 py-2 border-b">商品名</th>
                            <th class="px-4 py-2 border-b">購入数</th>
                            <th class="px-4 py-2 border-b">金額</th>
                            <th class="px-4 py-2 border-b">商品画像</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border-b">{{ $order->created_at->format('Y/m/d') }}</td>
                                <td class="px-4 py-2 border-b">{{ number_format($order->total_price) }}円</td>
                                <td class="px-4 py-2 border-b">{{ $order->status->getLabel() }}</td>
                                <td class="px-4 py-2 border-b" colspan="4">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <tbody>
                                            @foreach ($order->orderDetails as $detail)
                                                <tr class="hover:bg-gray-100">
                                                    <td class="px-4 py-2 border-b">{{ $detail->product->name }}</td>
                                                    <td class="px-4 py-2 border-b">{{ $detail->count }}</td>
                                                    <td class="px-4 py-2 border-b">
                                                        {{ number_format($detail->price_tax) }}円</td>
                                                    <td class="px-4 py-2 border-b">
                                                        <img src="{{ \Storage::url($detail->product->mainProductImage->image) }}"
                                                            alt="{{ $detail->product->name }}"
                                                            class="w-16 h-16 object-cover">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
