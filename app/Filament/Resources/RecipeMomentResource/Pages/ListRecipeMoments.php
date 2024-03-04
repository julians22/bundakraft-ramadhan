<?php

namespace App\Filament\Resources\RecipeMomentResource\Pages;

use App\Filament\Resources\RecipeMomentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecipeMoments extends ListRecords
{
    protected static string $resource = RecipeMomentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
