<?php

namespace App\Filament\Exports;

use App\Enums\Product\Status;
use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('status')
                ->formatStateUsing(function (Status $state, array $options): string {
                    return $state->getLabel();
                }),
            ExportColumn::make('name'),
            ExportColumn::make('description'),
            ExportColumn::make('price'),
            ExportColumn::make('count_max'),
            ExportColumn::make('count'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = '商品情報を '.number_format($export->successful_rows).'行ダウンロードしました。';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' 行エクスポートに失敗しました。';
        }

        return $body;
    }
}
