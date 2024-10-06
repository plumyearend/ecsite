<?php

namespace App\Http\Controllers;

use App\UseCases\Product\GetListAction;

class TopController extends Controller
{
    public function top(GetListAction $getListAction)
    {
        $products = $getListAction();
        dump($products);

        return view('top.index', ['products' => $products]);
    }
}
