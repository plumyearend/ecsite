<?php

namespace App\Livewire\Pages;

use App\Models\Order;
use App\UseCases\Cart\DeleteProductAction;
use App\UseCases\Cart\GetListAction;
use App\UseCases\Cart\UpdateProductCountAction;
use App\UseCases\Checkout\CreateOrderAction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function increaseCount(UpdateProductCountAction $updateProductCountAction, int $productId)
    {
        $this->list = $this->list->map(function ($item) use ($productId) {
            if ($item['product']->id === $productId) {
                $item['count']++;
            }

            return $item;
        });
        $updateProductCountAction($productId, $this->list[$productId]['count']);
        $this->updateTotalPrice();
    }

    public function decreaseCount(UpdateProductCountAction $updateProductCountAction, int $productId)
    {
        $this->list = $this->list->map(function ($item) use ($productId) {
            if ($item['product']->id === $productId) {
                $item['count']--;
            }

            return $item;
        });
        $updateProductCountAction($productId, $this->list[$productId]['count']);
        $this->updateTotalPrice();
    }

    public function removeItem(DeleteProductAction $deleteProductAction, int $productId)
    {
        $this->list->pull($productId);
        $deleteProductAction($productId);
        $this->updateTotalPrice();
    }

    private function updateTotalPrice()
    {
        $this->totalPrice = $this->list->sum(function ($item) {
            return $item['product']->price * $item['count'];
        });
    }

    public function toCheckout(CreateOrderAction $createOrderAction)
    {
        try {
            DB::beginTransaction();
            $order = $createOrderAction($this->list, $this->totalPrice);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception('エラーが発生しました。');
        }
        $encodedId = Order::encodeId($order->id);

        return redirect()->to(route('checkouts.information', ['encodedId' => $encodedId]));
    }

    public function redirectToLogin()
    {
        session(['url.intended' => url()->previous()]);

        return redirect()->to(route('account.login'));
    }

    public function redirectToSignup()
    {
        session(['url.intended' => url()->previous()]);

        return redirect()->to(route('account.signup'));
    }
}
