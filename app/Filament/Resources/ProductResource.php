<?php

namespace App\Filament\Resources;

use App\Enums\Product\Status;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = '商品';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('状態')
                    ->options(Status::list())
                    ->default(Status::PRIVATE)
                    ->required(),
                TextInput::make('name')
                    ->label('商品名')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('説明文')
                    ->required()
                    ->columnSpanFull()
                    ->autofocus(),
                TextInput::make('price')
                    ->label('価格（税抜き）')
                    ->numeric()
                    ->required()
                    ->prefix('¥'),
                Section::make('在庫')
                    ->schema([
                        TextInput::make('count_max')
                            ->label('最大在庫数')
                            ->numeric()
                            ->required(),
                        TextInput::make('count')
                            ->label('在庫数')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(2),
                Repeater::make('images')
                    ->relationship('productImages')
                    ->label('商品画像')
                    ->schema([
                        FileUpload::make('image')
                            ->label('画像')
                            ->directory('products')
                            ->visibility('private')
                            ->required(),
                    ])
                    ->reorderable()
                    ->orderColumn('sort')
                    ->grid(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('ステータス')
                    ->formatStateUsing(function ($state) {
                        return $state->label();
                    })
                    ->sortable(),
                TextColumn::make('name')
                    ->label('商品名')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('価格（税抜き）')
                    ->prefix('¥')
                    ->formatStateUsing(function ($state) {
                        return number_format($state);
                    })
                    ->sortable(),
                TextColumn::make('count_max')
                    ->label('在庫最大数')
                    ->sortable(),
                TextColumn::make('count')
                    ->label('在庫数')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('作成日時')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('更新日時')
                    ->sortable(),
            ])
            ->searchPlaceholder('検索 (商品名)')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
