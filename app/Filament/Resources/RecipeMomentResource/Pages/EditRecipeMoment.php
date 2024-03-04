<?php

namespace App\Filament\Resources\RecipeMomentResource\Pages;

use App\Filament\Resources\RecipeMomentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecipeMoment extends EditRecord
{
    protected static string $resource = RecipeMomentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
