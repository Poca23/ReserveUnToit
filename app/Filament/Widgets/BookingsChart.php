<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class BookingsChart extends ChartWidget
{
    protected static ?string $heading = 'Réservations par mois';

    protected function getData(): array
    {
        $bookings = Booking::select('created_at')
            ->get()
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->created_at)->format('F');
            });

        $months = [];
        $counts = [];

        $monthsTranslation = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre'
        ];

        foreach ($bookings as $month => $booking) {
            $months[] = $monthsTranslation[$month] ?? $month;
            $counts[] = count($booking);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Réservations',
                    'data' => $counts,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                    ],
                    'borderWidth' => 1
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
