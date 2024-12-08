<x-app-layout>
    @pushOnce('headScripts')
        <script src="https://js.stripe.com/v3/"></script>
    @endPushOnce

    <form id="stripe-form" method="POST" action="{{ route('checkouts.payment.store', $encodedId) }}">
        @csrf

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
                <h3 class="text-lg font-semibold">クレジットカード情報</h3>
                <div class="card-input-container">
                    <label for="card-element">クレジットカード番号</label>
                    <div id="card-number" class="stripe-card-input"></div>
                </div>
                <div class="card-input-container">
                    <label for="card-element">有効期限</label>
                    <div id="card-expiry" class="stripe-card-input"></div>
                </div>
                <div class="card-input-container">
                    <label for="card-element">セキュリティコード</label>
                    <div id="card-cvc" class="stripe-card-input"></div>
                </div>
                <div class="text-red-500" id="card-errors" role="alert"></div>
            </div>

            <button id="purchase-button" type="button"
                class="mt-6 w-full bg-indigo-600 text-white py-2 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                購入を確定する
            </button>
        </div>
        <input type="hidden" id="stripe_intent_id" name="stripe_intent_id" />
        <input type="hidden" id="stripe_method_id" name="stripe_method_id" />
    </form>

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
                const cardNumberElement = elements.create('cardNumber', {
                    style
                });
                cardNumberElement.mount('#card-number');
                const cardExpiryElement = elements.create('cardExpiry', {
                    style
                });
                cardExpiryElement.mount('#card-expiry');
                const cardCvcElement = elements.create('cardCvc', {
                    style
                });
                cardCvcElement.mount('#card-cvc');

                const purchaseButton = document.getElementById('purchase-button');
                purchaseButton.addEventListener('click', async () => {
                    const apiUrl = '/checkouts/' + @json($encodedId) + '/payment';
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
                            card: cardNumberElement,
                        },
                    });
                    console.log(paymentIntent)
                    console.log(stripeError)
                    if (stripeError) {
                        document.getElementById('card-errors').textContent = stripeError.message;
                    } else {
                        const intentIdElement = document.getElementById('stripe_intent_id');
                        const intentIdMethod = document.getElementById('stripe_method_id');
                        intentIdElement.setAttribute('value', paymentIntent.id);
                        intentIdMethod.setAttribute('value', paymentIntent.payment_method);

                        const form = document.getElementById('stripe-form');
                        form.submit();
                    }
                });
            });
        </script>
    @endPushOnce
</x-app-layout>
