<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentListingsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Property Listings';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Listing::query()->latest()->limit(5)
            )
            ->columns([
                ImageColumn::make('images')
                    ->label('Image')
                    ->circular()
                    ->stacked()
                    ->limit(1)
                    ->limitedRemainingText()
                    ->getStateUsing(function ($record) {
                        $images = $record->image_urls;
                        return !empty($images) ? [$images[0]] : [null];
                    })
                    ->size(60),
                TextColumn::make('title')
                    ->label('Property Title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->color('primary')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('availability')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'rent' => 'success',
                        'sale' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'rent' => 'For Rent',
                        'sale' => 'For Sale',
                        default => $state,
                    }),
                TextColumn::make('price')
                    ->label('Price')
                    ->searchable()
                    ->sortable()
                    ->money('SAR')
                    ->weight(FontWeight::Bold)
                    ->color('success'),
                TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 40) {
                            return null;
                        }
                        return $state;
                    })
                    ->icon(Heroicon::OutlinedMapPin)
                    ->iconColor('gray'),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn(Listing $record): string => route('filament.admin.resources.listings.view', $record)),
            ])
            ->paginated(false);
    }
}
