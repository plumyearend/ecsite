<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OrdersWidget extends BaseWidget
{
    protected static ?string $heading = '注文履歴';

    protected int | string | array $columnSpan = 'full';

    public ?Product $record = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->withWhereHas('orderDetails', function ($query) {
                        $query->where('product_id', $this->record->id);
                    })
            )
            ->columns([
                TextColumn::make('id')
                    ->label('オーダーID'),
                TextColumn::make('user.name')
                    ->label('購入者'),
                TextColumn::make('status')
                    ->label('注文ステータス'),
                TextColumn::make('created_at')
                    ->label('注文日時')
                    ->dateTime('Y/m/d H:i'),
            ])
            ->defaultSort('id', 'desc');
    }
}
