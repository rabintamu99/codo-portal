<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Filament\Resources\AssignmentResource\RelationManagers;
use Filament\Forms\Components\RichEditor;
use App\Models\Assignment;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Htmlable;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\HtmlString;
use App\Filament\Widgets\AssignmentsScoreWidget;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Resources\Components\Tab;



class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'タスク';

    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'タスク';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('subject')
            ->label('subject')
            ->options(Subject::all()->pluck('name', 'id')),
            Forms\Components\DateTimePicker::make('deadline'),
            Forms\Components\TextInput::make('title')
            ->required()
            ->columnSpan([
                'sm' => 12, 
            ]),
        Forms\Components\MarkdownEditor::make('description')
        ->fileAttachmentsDisk('public')
        ->fileAttachmentsDirectory('description_images') 
            ->columnSpan([
                'sm' => 12, 
            ]),
            Forms\Components\FileUpload::make('file_path')
            ->label('')
            ->disk('public')
            ->directory('task_files')
            ->columnSpan([
                'sm' => 12, 
            ]),
        ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('課題名')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('deadline')
                ->label('締切')
                ->searchable(),
            //   Tables\Columns\IconColumn::make('is_featured')
            //     ->label('提出状況')
            //     ->boolean(),
                Tables\Columns\IconColumn::make('submitted')
    ->label('提出状況')
    ->getStateUsing(function ($record) {
        $studentId = auth()->user()->id; // or get the student ID dynamically
        $student = $record->students()->where('student_id', $studentId)->first();
        return $student ? $student->pivot->submitted : false;
    })
    ->trueIcon('heroicon-s-check-circle')
    ->falseIcon('heroicon-s-x-circle'),

            ])

            ->actions([

                
                Tables\Actions\Action::make('upload')
                    ->label('提出')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        Forms\Components\FileUpload::make('assignment_file')
                            ->label('ファイルを下で選択するか、ここにドロップしてください')
                            ->disk('public')
                            ->directory('assignment_submissions')
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        // Handle file upload and update pivot table
                        $studentId = auth()->user()->id; // or get the student ID dynamically
                        $record->students()->updateExistingPivot($studentId, [
                            'file_path' => $data['assignment_file'],
                            'submitted' => true,
                        ]);
                    }),


                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'action' => Pages\CreateAssignment::route('/{record}/create'),
            'view' => Pages\ViewAssignment::route('/{record}'),
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }
}
