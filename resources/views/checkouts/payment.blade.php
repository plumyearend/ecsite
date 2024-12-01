<x-app-layout>
    @pushOnce('headScripts')
        <script src="https://js.stripe.com/v3/"></script>
    @endPushOnce

    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title -->
        <div class="max-w-2xl text-center mx-auto mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-black">サイトトップ</h2>
        </div>

        <!-- 商品情報 -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold">選択した商品</h3>
            <ul class="border rounded p-4">
                @foreach ($orderDetails as $orderDetail)
                    <li class="flex items-center justify-between border-b py-2">
                        <div>
                            <p class="font-medium">{{ $orderDetail['product']['name'] }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">{{ number_format($orderDetail['price_tax']) }} 円</p>
                            <p class="text-sm text-gray-600">個数: {{ $orderDetail['count'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="text-right mt-4">
                <p class="text-lg font-bold">合計金額: {{ number_format($order->total_price) }} 円</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="card-input-container">
                <label for="card-element">クレジットカード情報</label>
                <div id="card-element" class="stripe-card-input"></div>
                <div id="card-errors" role="alert"></div>
            </div>
        </div>

        <button id="purchase-button"
            class="mt-6 w-full bg-indigo-600 text-white py-2 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            購入を確定する
        </button>
    </div>

    @pushOnce('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                const order = @json($order);
                const stripe = Stripe('{{ config('services.stripe.key') }}');
                const style = {
                    base: {
                        color: '#32325d',
                        fontSize: '16px',
                        fontFamily: 'Arial, sans-serif',
                        '::placeholder': {
                            color: '#aab7c4'
                        },
                        backgroundColor: '#f7f7f7',
                        padding: '10px',
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };
                const elements = stripe.elements();
                const cardElement = elements.create('card', {
                    style
                });
                cardElement.mount('#card-element');

                const purchaseButton = document.getElementById('purchase-button');
                purchaseButton.addEventListener('click', async () => {
                    const apiUrl = '/checkouts/' + @json($encodedId) + '/payment';
                    console.log('{{ csrf_token() }}');
                    const response = await fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            amount: order.total_price,
                        }),
                    });
                    const {
                        clientSecret,
                        error
                    } = await response.json();

                    if (error) {
                        document.getElementById('card-errors').textContent = error;
                        return;
                    }

                    const {
                        paymentIntent,
                        error: stripeError
                    } = await stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: cardElement,
                        },
                    });
                    if (stripeError) {
                        document.getElementById('card-errors').textContent = stripeError.message;
                    } else {
                        // TODO: 決済完了画面へ遷移する
                        alert('支払いが完了しました！');
                    }
                });
            });
        </script>
    @endPushOnce
</x-app-layout>
