<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeMomentResource\Pages;
use App\Filament\Resources\RecipeMomentResource\RelationManagers;
use App\Models\RecipeMoment;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecipeMomentResource extends Resource
{
    protected static ?string $model = RecipeMoment::class;

    protected static ?string $navigationGroup = 'Recipe Management';

    protected static ?string $navigationLabel = 'Moment';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('slug')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRecipeMoments::route('/'),
            'create' => Pages\CreateRecipeMoment::route('/create'),
            'edit' => Pages\EditRecipeMoment::route('/{record}/edit'),
        ];
    }
}
