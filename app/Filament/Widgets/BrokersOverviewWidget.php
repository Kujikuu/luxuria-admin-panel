<?php

namespace App\Filament\Widgets;

use App\Models\Broker;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BrokersOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBrokers = Broker::count();
        $activeBrokers = Broker::whereNotNull('phone')->count();
        $brokersWithSocial = Broker::where(function($query) {
            $query->whereNotNull('x_profile')
                  ->orWhereNotNull('linkedin_profile');
        })->count();
        $averageExperience = Broker::whereNotNull('years_of_experience')->avg('years_of_experience');

        return [
            Stat::make('Total Brokers', $totalBrokers)
                ->description('Registered brokers')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Active Brokers', $activeBrokers)
                ->description('With contact info')
                ->descriptionIcon('heroicon-m-phone')
                ->color('success'),

            Stat::make('Social Media Presence', $brokersWithSocial)
                ->description('Brokers with social profiles')
                ->descriptionIcon('heroicon-m-share')
                ->color('info'),
        ];
    }
}