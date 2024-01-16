<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class ViewAssignment extends ViewRecord
{
    protected static string $resource = AssignmentResource::class;


    public function infolist(Infolist $infolist): Infolist

    {
        return $infolist
            ->schema([
                Section::make('ないよう')
                    ->description('')
                    ->schema([
                        TextEntry::make('title'),
                        ImageEntry::make('description'),
                        //->html(),
                        TextEntry::make('deadline'),
                    ])
                    ->collapsed(false), // Set to true to initially collapse the section

                Section::make('フアイル')
                    ->description('')
                    ->schema([
                        ImageEntry::make('file_path')
                          ->disk('public')
                        //   ->label('File')
                          ->url(fn ($record) => asset('storage/' . $record->file_path)),
                            ])
                 ->collapsed(false),
                 Section::make('コメント')
                 ->description('')
                 ->schema([
               
                         ])
              ->collapsed(false),
            ]);
    }

 
}
