<x-app-layout>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title -->
        <div class="max-w-2xl text-center mx-auto mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-black">マイページ</h2>
        </div>
        <div class="max-w-5xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
                <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition"
                    href="{{ route('account.addresses.index') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex gap-x-5">
                            <div class="grow">
                                <h3 class="group-hover:text-blue-600 font-semibold text-gray-800">
                                    お届け先リスト
                                </h3>
                                <p class="text-sm text-gray-500">
                                    お届け先の確認・編集ができます。
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition"
                    href="{{ route('account.order-history') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex gap-x-5">
                            <div class="grow">
                                <h3 class="group-hover:text-blue-600 font-semibold text-gray-800">
                                    購入履歴
                                </h3>
                                <p class="text-sm text-gray-500">
                                    購入履歴の確認ができます。
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
