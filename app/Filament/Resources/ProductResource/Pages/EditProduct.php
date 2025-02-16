<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
            // ->submit('save')
            ->requiresConfirmation()
            ->action(fn() => $this->save())
            ->modalDescription(fn() => '在庫が0の状態です。保存しますか？')
            ->modalHidden(fn() => $this->data['count'] > 0)
            ->keyBindings(['mod+s']);
    }
}
