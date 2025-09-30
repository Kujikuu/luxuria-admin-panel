<?php

namespace App\Filament\Resources\Listings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class ListingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Enter the basic details of the property listing')
                    ->icon(Heroicon::OutlinedInformationCircle)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Property Title')
                                    ->placeholder('Enter a descriptive title for the property')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->columnSpan(1),
                                Select::make('availability')
                                    ->label('Availability Status')
                                    ->options([
                                        'rent' => 'For Rent',
                                        'sale' => 'For Sale',
                                        'sold' => 'Sold',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(1),
                            ]),
                        Hidden::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(table: 'listings', column: 'slug', ignoreRecord: true),
                        RichEditor::make('description')
                            ->label('Property Description')
                            ->placeholder('Provide a detailed description of the property...')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Property Details')
                    ->description('Specify the property characteristics and features')
                    ->icon(Heroicon::OutlinedBuildingOffice2)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Price')
                                    ->placeholder('Enter price')
                                    ->prefix('SAR')
                                    ->numeric()
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('living_space')
                                    ->label('Living Space')
                                    ->placeholder('e.g., 1200 sq ft')
                                    ->suffix('sq ft')
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('completion_year')
                                    ->label('Year Built')
                                    ->placeholder('e.g., 2020')
                                    ->numeric()
                                    ->minValue(1800)
                                    ->maxValue(date('Y') + 5)
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('floors')
                                    ->label('Number of Floors')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(50)
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('bedrooms')
                                    ->label('Bedrooms')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(20)
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('bathrooms')
                                    ->label('Bathrooms')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(20)
                                    ->step(0.5)
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                        TextInput::make('address')
                            ->label('Property Address')
                            ->placeholder('Enter the complete address')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Property Images')
                    ->description('Upload high-quality images of the property')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->schema([
                        FileUpload::make('images')
                            ->label('Property Images')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('listings')
                            ->visibility('public')
                            ->required()
                            ->maxFiles(3)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif'])
                            ->maxSize(5120) // 5MB
                            ->helperText('Upload up to 3 high-quality images. Recommended size: 1920x1080px or higher.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
