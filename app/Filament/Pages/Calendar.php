<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Calendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'カレンダー';
    protected static string $view = 'filament.pages.calendar';
    protected static ?string $modelLabel = 'カレンダー';
}
