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
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Notifications\Notification;
use Filament\Forms;


class AssignSubmit extends ViewRecord
{
    protected static string $resource = AssignmentResource::class;
   // protected static string $view = 'filament.users';

   public static function getNavigationLabel(): string
   {
       return '提出状況';
   }


   public static function table(Table $table): Table
   {
       return $table
           ->columns([
               Tables\Columns\TextColumn::make('title')
               ->label('タスク名')
               ->searchable(),
              // ->sortable(),
               Tables\Columns\TextColumn::make('deadline')
               ->label('期限日')
               ->searchable(),
               Tables\Columns\IconColumn::make('submitted')
               ->label('提出状況')
               ->getStateUsing(function ($record) {
               $userId = auth()->user()->id; // Get the logged-in user's ID
               $assignment = $record->students()->where('users.id', $userId)->first(); // Adjust table and column names as necessary
       
               return $assignment ? $assignment->pivot->submitted : false;
           })
           ->trueIcon('heroicon-s-check-circle')
           ->falseIcon('heroicon-s-x-circle'),
           ])

   
           ->defaultSort('title', 'desc')

           ->actions([
                   Tables\Actions\Action::make('upload')
                   ->label('提出')
                   ->icon('heroicon-o-arrow-up-tray')
                   ->form([
                       Forms\Components\FileUpload::make('task_file')
                           ->label('ファイルを下で選択するか、ここにドロップしてください')
                           ->disk('public')
                           ->storeAsOriginalName() 
                           ->directory('task_uploads')
                           ->required(),
                   ])
                   ->action(function ($record, $data) {
                          // Check if the current time is past the assignment deadline
                       if (now()->greaterThan($record->deadline)) {
                           Notification::make()
                           ->title('締切日を過ぎています。提出できません。')
                           ->warning()
                           ->send();
                       return;
                       }

                       $studentId = auth()->user()->student->id; // Assuming the logged-in user is a student
                       $filePath = $data['task_file']; // Get uploaded file path
               
                       $record->students()->syncWithoutDetaching([
                           $studentId => ['file_path' => $filePath, 'submitted' => true]
                       ]);
                       Notification::make()
                       ->title('提出しました')
                       ->success()
                       ->send();
                   }),
                
               Tables\Actions\ViewAction::make(),
               Tables\Actions\EditAction::make(),
               
           ])
           ->bulkActions([
               // Tables\Actions\BulkActionGroup::make([
               //     Tables\Actions\DeleteBulkAction::make(),
               // ]),
           ]);
   }
    public function infolist(Infolist $infolist): Infolist

   {

        return $infolist
            ->schema([
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
