<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Filament\Resources\RecipeResource\RelationManagers;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Components\Builder as ComponentsBuilder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Grid::make([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                ->schema([
                    Section::make('Basic Information')
                        ->id('basic-information')
                        ->columnSpan([
                            'default' => 1,
                            'sm' => 2,
                            'md' => 3,
                            'lg' => 4,
                            'xl' => 4,
                            '2xl' => 6,
                        ])
                        ->columns(1)
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(120),
                            RichEditor::make('description'),
                            ComponentsBuilder::make('ingredients')
                                ->blocks([
                                    Block::make('ingredient')
                                        ->schema([
                                            TextInput::make('title'),
                                            Repeater::make('items')
                                                ->simple(Textarea::make('value')),

                                        ])
                                        ]),
                            ComponentsBuilder::make('instruction')
                                ->blocks([
                                    Block::make('instruction')
                                        ->schema([
                                            TextInput::make('title'),
                                            Repeater::make('items')
                                                ->simple(Textarea::make('value')),

                                        ])
                                ])
                        ]),
                        Section::make('Advance Information')
                            ->id('advance-information')
                            ->columnSpan([
                                'default' => 1,
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 2,
                                '2xl' => 2,
                            ])
                            ->columns(1)
                            ->schema([
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
                                CheckboxList::make('moments')
                                    ->relationship('moments', 'title')
                                    ->searchable(),
                                SpatieMediaLibraryFileUpload::make('thumbnail')
                                    ->fetchFileInformation(false)
                                    ->image()
                                    ->maxSize(2048)
                                    ->collection('recipes'),

                                Toggle::make('status')
                                    ->default(true)
                                    ->onIcon('heroicon-o-check-circle')
                                    ->offIcon('heroicon-o-x-circle')
                                    ->onColor('success')
                                    ->offColor('danger'),
                                Toggle::make('is_award')
                                    ->default(false)
                                    ->onIcon('heroicon-o-check-circle')
                                    ->offIcon('heroicon-o-x-circle')
                                    ->onColor('success')
                                    ->offColor('danger'),
                                ComponentsBuilder::make('video_url')
                                        ->blockNumbers(false)
                                        ->blocks([
                                            Block::make('youtube_full_url')
                                                ->maxItems(1)
                                                ->schema([
                                                    TextInput::make('youtube_full_url')
                                                            ->url()
                                                ]),
                                            Block::make('youtube_id')
                                                ->maxItems(1)
                                                ->schema([
                                                    TextInput::make('youtube_id')
                                                ]),

                                        ])
                            ])
                ])

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
                    ->defaultImageUrl(url('/images/product_theme.png'))
                    ->collection('recipes'),
                IconColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        '0' => 'heroicon-o-x-circle',
                        '1' => 'heroicon-o-check-circle',
                        default => 'heroicon-o-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                        default => 'danger',
                    }),
                ToggleColumn::make('is_award'),
                TextColumn::make('sort')
                    ->sortable(),
                TextColumn::make('moments.title')
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->since()
                    ->sortable()
                    ->dateTimeTooltip(),
                TextColumn::make('updated_at')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()

            ])
            ->filters([
                Filter::make('status')
                    ->query(fn (Builder $query): Builder => $query->where('status', true)),
                SelectFilter::make('moments')
                    ->relationship('moments', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort', 'asc')
            ->reorderable('sort');
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
