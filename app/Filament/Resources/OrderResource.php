<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = '注文情報';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Section::make('配送先')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('名前（名）')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('名前（姓）')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('postcode')
                            ->label('郵便番号')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('prefecture_id')
                            ->label('住所（都道府県）')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('address1')
                            ->label('住所（市区町村）')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address2')
                            ->label('住所（地名・番地）')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address3')
                            ->label('住所（建物名・部屋番号）')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tel')
                            ->label('電話番号')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ])
                    ->columns(2),
                Forms\Components\TextInput::make('shipping_fee')
                    ->label('送料')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_price')
                    ->label('請求金額')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->label('注文ステータス')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->label('ステータス'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('ユーザー名'),
                Tables\Columns\TextColumn::make('total_price')
                    ->searchable()
                    ->sortable()
                    ->label('金額'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
