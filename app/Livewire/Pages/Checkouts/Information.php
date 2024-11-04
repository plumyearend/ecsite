<?php

namespace App\Livewire\Pages\Checkouts;

use App\Models\Order;
use App\UseCases\Account\Address\GetListAction;
use App\UseCases\Account\GetPrefecturesAction;
use Livewire\Component;

class Information extends Component
{
    public Order $order;
    public $orderDetails;
    public $addresses;
    public int $selectAddressId;
    public $prefectures;

    public string $postcode;
    public int $prefecture_id;
    public string $address1;
    public string $address2;
    public ?string $address3;
    public string $tel;

    public function mount(
        GetListAction $getListAction,
        GetPrefecturesAction $getPrefecturesAction,
    ) {
        $this->addresses = $getListAction();
        $this->prefectures = $getPrefecturesAction();
        $this->selectAddressId = $this->addresses->firstWhere('is_default_address', true)->id;
        $this->setAddress();

        $this->orderDetails = $this->order->orderDetails()
            ->select([
                'product_id',
                'count',
                'price_tax',
            ])
            ->with('product', function ($query) {
                $query->select([
                    'id',
                    'status',
                    'name',
                    'price',
                ]);
                $query->with('mainProductImage', function ($query) {
                    $query->select([
                        'product_id',
                        'image',
                    ]);
                });
            })
            ->orderBy('id')
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.checkouts.information');
    }

    public function setAddress()
    {
        $address = $this->addresses->firstWhere('id', $this->selectAddressId);
        $this->postcode = $address->postcode;
        $this->prefecture_id = $address->prefecture_id;
        $this->address1 = $address->address1;
        $this->address2 = $address->address2;
        $this->address3 = $address->address3;
        $this->tel = $address->tel;
    }
}
