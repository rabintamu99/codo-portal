<?php
 
namespace App\Filament\Widgets;
 
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
 
class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Cプログラミング 提出%', '90%')
            ->description('8% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),
        Stat::make('VBA 提出%', '81%')
            ->description('7% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('danger'),
       
        ];
    }

}