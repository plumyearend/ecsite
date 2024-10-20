<?php

namespace App\Livewire\Pages;

use App\UseCases\Cart\GetListAction;
use Livewire\Component;

class Cart extends Component
{
    public $list;
    public $totalPrice;

    public function mount(GetListAction $getListAction)
    {
        $this->list = $getListAction();
        $this->updateTotalPrice();
    }

    public function render()
    {
        return view('livewire.pages.cart');
    }

    public function increaseQuantity($productId)
    {
        // TODO: 商品増加
        $this->updateTotalPrice();
    }

    public function decreaseQuantity($productId)
    {
        // TODO: 商品減少
        $this->updateTotalPrice();
    }

    public function removeItem($productId)
    {
        // TODO: 商品削除

        $this->updateTotalPrice();
    }

    private function updateTotalPrice()
    {
        $this->totalPrice = $this->list->sum(function ($item) {
            return $item['product']->price * $item['quantity'];
        });
    }
}
