<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use Filament\Actions;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Contracts\View\View;
use Filament\Forms\Form;
use Filament\Infolists\Components\ViewEntry;

class ViewAssignment extends ViewRecord
{
    protected static string $resource = AssignmentResource::class;
   // protected static string $view = 'filament.users';

    public function infolist(Infolist $infolist): Infolist

    {
        return $infolist
            ->schema([
                Section::make('ないよう')
                    ->description('')
                    ->schema([
                        TextEntry::make('title')
                        ->label(''),
                        TextEntry::make('description')
                        ->label('')
                        ->markdown(),
                        TextEntry::make('deadline')
                        ->icon('heroicon-o-clock')
                        ->badge()
                       ->date()
                        ->label('締切'),
                        
                       
                    ])
                    ->collapsed(false), // Set to true to initially collapse the section

                Section::make('フアイル')
                    ->description('')
                    ->schema([
                        ImageEntry::make('file_path')
                          ->disk('public')
                          ->label('ダウンロドする')
                        
                          ->url(fn ($record) => asset('storage/' . $record->file_path)),
                            ])
                 ->collapsed(false),
                 Section::make('提出条件')
                 ->description('提出した学生一覧')
                 ->schema([
                     ViewEntry::make('submittedUsers')
                         ->view('filament.users', [
                             'submittedUsers' => $this->record->submittedUsers,
                         ]),
                 ])
                 ->collapsed(false),

                

             
          
        ]);
    }
}