<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('id')
                    ->label('オーダーID'),
                TextEntry::make('user.name')
                    ->label('ユーザー名'),
                TextEntry::make('total_price')
                    ->label('請求金額')
                    ->numeric()
                    ->suffix('円'),
                TextEntry::make('shipping_fee')
                    ->label('送料')
                    ->numeric()
                    ->suffix('円'),
                TextEntry::make('status')
                    ->label('ステータス'),
                TextEntry::make('created_at')
                    ->label('注文日時')
                    ->dateTime('Y/m/d H:i'),
                RepeatableEntry::make('orderDetails')
                    ->label('注文商品')
                    ->schema([
                        TextEntry::make('id')
                            ->label('商品ID'),
                        TextEntry::make('product.name')
                            ->label('商品名'),
                        TextEntry::make('count')
                            ->label('個数'),
                        TextEntry::make('price_tax')
                            ->label('価格（税込み）'),
                    ])
                    ->grid(3)
                    ->columnSpanFull(),
                Section::make('送り先住所')
                    ->schema([
                        TextEntry::make('orderAddress.last_name')
                            ->label('名前')
                            ->formatStateUsing(function ($state) {
                                return $state . ' ' . $this->record->orderAddress->first_name;
                            }),
                        TextEntry::make('orderAddress.postcode')
                            ->label('郵便番号'),
                        TextEntry::make('orderAddress.prefecture.name')
                            ->label('都道府県'),
                        TextEntry::make('orderAddress.address1')
                            ->label('市区町村'),
                        TextEntry::make('orderAddress.address2')
                            ->label('地名・番地'),
                        TextEntry::make('orderAddress.address3')
                            ->label('建物名・部屋番号'),
                        TextEntry::make('orderAddress.tel')
                            ->label('電話番号'),
                    ])
                    ->columns(2),
            ]);
    }
}
