<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Tableau de bord';
    protected static ?string $title = 'Tableau de bord';
    protected static string $view = 'filament.pages.tableau-de-bord';
    protected static ?string $slug = 'tableau-de-bord';
    public static function getNavigationSort(): ?int
    {
        return -2;
    }
}
