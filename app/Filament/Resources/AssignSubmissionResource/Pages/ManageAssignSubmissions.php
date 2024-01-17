<?php

namespace App\Filament\Resources\AssignSubmissionResource\Pages;

use App\Filament\Resources\AssignSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAssignSubmissions extends ManageRecords
{
    protected static string $resource = AssignSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
