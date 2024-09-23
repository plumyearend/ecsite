<x-app-layout>
    <!-- Card Blog -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title -->
        <div class="max-w-2xl text-center mx-auto mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-black">お届け先リスト</h2>
        </div>
        <!-- End Title -->

        @if (session('address_saved'))
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
            お届け先を追加しました。
        </div>
        @endif
        @if (session('address_updated'))
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
            お届け先を更新しました。
        </div>
        @endif

        <!-- Grid -->
        <div class="grid grid-cols-2 gap-6 mb-10 lg:mb-14">
            @foreach ($addresses as $address)
            <!-- Card -->
            <div class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-medium text-gray-800">
                            お届け先{{ $loop->iteration }}
                        </h3>
                        @if ($address->is_default_address)
                        <p class="bg-cyan-600 text-white text-xs rounded border border-transparen p-1">既定のお届け先</p>
                        @endif
                    </div>
                    <p class="mt-2 text-base font-medium text-gray-600">
                        〒{{ $address->postcode_hyphen }}
                    </p>
                    <p class="mt-2 text-base font-medium text-gray-600">
                        {{ $prefectures[$address->prefecture_id] }} {{ $address->address1 }} {{ $address->address2 }} {{ $address->address3 }}
                    </p>
                    <p class="mt-2 text-base font-medium text-gray-600">
                        電話番号: {{ $address->tel }}
                    </p>
                    <p class="mt-2 text-base font-medium text-gray-600">
                        {{ $address->last_name }} {{ $address->first_name }}
                    </p>
                    <div class="flex justify-center">
                        <a class="mt-5 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                            href="{{ route('account.addresses.edit', $address->id) }}">
                            編集
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            @endforeach
        </div>
        <!-- End Grid -->

        <!-- Card -->
        <div class="text-center">
            <div class="inline-block bg-white border shadow-sm rounded-full">
                <div class="py-3 px-4 flex items-center gap-x-2">
                    <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium"
                        href="{{ route('account.addresses.create')}}">
                        新しいお届け先を追加
                    </a>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Card Blog -->
</x-app-layout>
