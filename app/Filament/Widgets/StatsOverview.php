<?php
 
namespace App\Filament\Widgets;
 
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


 
class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
         
        Stat::make('Processed', '192.1k')
        ->color('success')
        ->extraAttributes([
            'class' => 'cursor-pointer',
            'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
        ]),
        ];
    }
}