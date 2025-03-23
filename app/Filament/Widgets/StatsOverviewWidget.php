<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total des propriétés', Property::count())
                ->description('Nombre total de propriétés')
                ->descriptionIcon('heroicon-m-home')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
                
            Stat::make('Total des réservations', Booking::count())
                ->description('Nombre total de réservations')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('warning'),
                
            Stat::make('Utilisateurs', User::count())
                ->description('Nombre total d\'utilisateurs')
                ->descriptionIcon('heroicon-m-user')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
        ];
    }
}
