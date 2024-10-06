<x-app-layout>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title -->
        <div class="max-w-2xl text-center mx-auto mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-black">サイトトップ</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 lg:mb-14">
        </div>
    </div>
    <div class="swiper container mx-auto px-4">
        <div class="swiper-wrapper">
            @foreach ($products as $product)
                <a class="swiper-slide" href="">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img class="w-full h-48 object-cover"
                            src="{{ \Storage::url($product->productImages[0]->image) }}" alt="{{ $product->name }}">
                        <div class="p-4">
                            <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                            <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                            <div class="mt-4">
                                <span class="text-xl font-semibold">{{ $product->price }}円</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</x-app-layout>
