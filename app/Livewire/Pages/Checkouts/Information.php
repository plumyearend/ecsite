<?php

namespace App\Livewire\Pages\Checkouts;

use App\Models\Order;
use Livewire\Component;

class Information extends Component
{
    public Order $order;

    public function render()
    {
        // TODO: 登録済みのお届け先住所を取得
        return view('livewire.pages.checkouts.information');
    }
}
