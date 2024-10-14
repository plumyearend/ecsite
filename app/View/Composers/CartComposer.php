<?php

namespace App\View\Composers;

use App\UseCases\Cart\GetCountAction;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $getCountAction = new GetCountAction();
        $view->with('cartCount', $getCountAction());
    }
}
