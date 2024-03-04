<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Filament\Resources\RecipeResource\RelationManagers;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Tags\Tag;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static ?string $navigationGroup = 'Recipe Management';

    protected static ?string $navigationLabel = 'All Recipes';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'icomoon-book';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(120),
                SpatieTagsInput::make('tags')
                    ->type('recipes')
                    ->suggestions([
                        __('5 Menit'),
                        __('10 Menit'),
                        __('15 Menit'),
                        __('2 Orang'),
                        __('3 Orang')
                    ])
                    ->reorderable()
                    ->label('Tags')
                    ->required(),
                Select::make('recipe_moment_id')
                    ->relationship(name: 'moment', titleAttribute: 'title'),
                SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->fetchFileInformation(false)
                    ->collection('recipes'),
                Repeater::make('ingredients')
                    ->simple(Textarea::make('value')),
                Repeater::make('instruction')
                    ->simple(Textarea::make('value')),
                Toggle::make('status')
                    ->default(true)
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                SpatieTagsColumn::make('tags'),
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('recipes'),
                IconColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        '0' => 'heroicon-o-check-x-circle',
                        '1' => 'heroicon-o-check-circle'
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                    }),
                TextColumn::make('moment.slug')
                    ->searchable(),
            ])
            ->filters([
                Filter::make('status')
                    ->query(fn (Builder $query): Builder => $query->where('status', true))
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
