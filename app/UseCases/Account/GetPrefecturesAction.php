<?php

namespace App\UseCases\Account;

use App\Models\Prefecture;
use Illuminate\Support\Collection;

class GetPrefecturesAction
{
    public function __invoke(): Collection
    {
        $prefectures = Prefecture::query()
            ->orderBy('id')
            ->get();

        return $prefectures->mapWithKeys(fn($item) => [$item->id => $item->name]);
    }
}
