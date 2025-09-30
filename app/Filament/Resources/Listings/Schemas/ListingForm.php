<?php

namespace App\Filament\Resources\Listings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ListingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->live()    
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Hidden::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('availability')
                    ->label('Availability')
                    ->options([
                        'rent' => 'For Rent',
                        'sale' => 'For Sale',
                    ])
                    ->required(),
                RichEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('images')
                    ->label('Images')
                    ->multiple()
                    ->image()
                    ->disk('public')
                    ->directory('listings')
                    ->visibility('public')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->label('Price')
                    ->required(),
                TextInput::make('living_space')
                    ->label('Living Space')
                    ->required(),
                TextInput::make('address')
                    ->label('Address')
                    ->required(),
                TextInput::make('completion_year')
                    ->label('Completion Year')
                    ->numeric()
                    ->required(),
                TextInput::make('floors')
                    ->label('Floors')
                    ->numeric()
                    ->required(),
                TextInput::make('bedrooms')
                    ->label('Bedrooms')
                    ->numeric()
                    ->required(),
                TextInput::make('bathrooms')
                    ->label('Bathrooms')
                    ->numeric()
                    ->required(),
            ]);
    }
}
