<?php

namespace App\Livewire\Pages\Checkouts;

use App\Rules\PostcodeFormat;
use App\Rules\TelFormat;
use App\Models\Order;
use App\UseCases\Account\Address\GetListAction;
use App\UseCases\Account\GetPrefecturesAction;
use App\UseCases\Checkout\GetOrderAction;
use App\UseCases\Checkout\GetOrderDetailsAction;
use Livewire\Component;

class Information extends Component
{
    public string $encodedId;
    public Order $order;
    public $orderDetails;
    public $addresses;
    public int $selectAddressId;
    public $prefectures;

    public string $last_name;
    public string $first_name;
    public string $postcode;
    public int $prefecture_id;
    public string $address1;
    public string $address2;
    public ?string $address3;
    public string $tel;

    protected function rules()
    {
        return [
            'last_name' => ['bail', 'required', 'string', 'max:100'],
            'first_name' => ['bail', 'required', 'string', 'max:100'],
            'postcode' => ['bail', 'required', new PostcodeFormat],
            'prefecture_id' => ['bail', 'required', 'exists:prefectures,id'],
            'address1' => ['bail', 'required', 'string', 'max:100'],
            'address2' => ['bail', 'nullable', 'string', 'max:100'],
            'address3' => ['bail', 'nullable', 'string', 'max:100'],
            'tel' => ['bail', 'required', new TelFormat],
        ];
    }

    public function mount(
        GetOrderAction $getOrderAction,
        GetListAction $getListAction,
        GetPrefecturesAction $getPrefecturesAction,
        GetOrderDetailsAction $getOrderDetailsAction,
    ) {
        $this->order = $getOrderAction($this->encodedId);
        $this->addresses = $getListAction();
        $this->prefectures = $getPrefecturesAction();
        $this->selectAddressId = $this->addresses->firstWhere('is_default_address', true)->id;
        $this->setAddress();

        $this->orderDetails = $getOrderDetailsAction($this->order)->toArray();
    }

    public function render()
    {
        return view('livewire.pages.checkouts.information');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function setAddress()
    {
        $address = $this->addresses->firstWhere('id', $this->selectAddressId);
        $this->last_name = $address->last_name;
        $this->first_name = $address->first_name;
        $this->postcode = $address->postcode;
        $this->prefecture_id = $address->prefecture_id;
        $this->address1 = $address->address1;
        $this->address2 = $address->address2;
        $this->address3 = $address->address3;
        $this->tel = $address->tel;
    }
}
