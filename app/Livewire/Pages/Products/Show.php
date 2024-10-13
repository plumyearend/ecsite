<?php

namespace App\Livewire\Pages\Products;

use App\Models\Product;
use App\Models\ProductImage;
use App\UseCases\Cart\AddProductAction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    public Product $product;
    public ProductImage $selectImage;
    public $quantity = 1;
    public $isShowModal = false;

    public function mount()
    {
        $this->selectImage = $this->product->productImages[0];
    }

    public function changeImage(ProductImage $productImage)
    {
        $this->selectImage = $productImage;
    }

    public function add(AddProductAction $addProductAction)
    {
        try {
            DB::beginTransaction();
            $addProductAction($this->product, $this->quantity);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception('カートに追加できませんでした。');
        }

        $this->isShowModal = true;
    }

    public function closeModal()
    {
        $this->isShowModal = false;
    }

    public function render()
    {
        return view('livewire.pages.products.show');
    }
}
