<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAssignments extends ListRecords
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Cプログラミング' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('subject', 1)),
            'VBA' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('subject', 2)),
        ];
    }
    
}
