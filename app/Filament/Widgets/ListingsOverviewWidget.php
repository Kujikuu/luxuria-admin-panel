<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ListingsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalListings = Listing::count();
        $availableListings = Listing::where('availability', 'rent')->orWhere('availability', 'sale')->count();
        $soldListings = Listing::where('availability', 'sold')->count();
        $averagePrice = Listing::where('availability', 'rent')->orWhere('availability', 'sale')->avg('price');

        return [
            Stat::make('Total Properties', $totalListings)
                ->description('All properties in system')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make('Available Properties', $availableListings)
                ->description('Ready for sale')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Sold Properties', $soldListings)
                ->description('Successfully sold')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),

            Stat::make('Average Price', 'SAR ' . number_format($averagePrice ?? 0, 0))
                ->description('For available properties')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}
