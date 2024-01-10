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



class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '課題';

    protected static ?string $navigationGroup = 'Cプログラミング';

    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';

    

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('subject')
            ->label('subject')
            ->options(Subject::all()->pluck('name', 'id')),
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
            Forms\Components\DateTimePicker::make('deadline'),
            Forms\Components\FileUpload::make('file_path')
           // ->imagePreviewHeight('250')
            ->loadingIndicatorPosition('left')
            ->panelAspectRatio('2:1')
            ->panelLayout('integrated')
            ->removeUploadedFileButtonPosition('right')
            ->uploadButtonPosition('left')
            ->uploadProgressIndicatorPosition('left')
            ->multiple() 
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
                ->searchable(),
                // Tables\Columns\TextColumn::make('description')
                // ->searchable(),
                Tables\Columns\TextColumn::make('deadline')
                ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject.name')->options([
                    'Cプログラミング' => 'Cプログラミング',
                    'VBA' => 'VBA',
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
               
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

 
    public static function infolist(InfoList $infolist): InfoList
    {
        return $infolist
            ->schema([
                Section::make('かだい ないよう')
                    ->description('')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Title'),
                        TextEntry::make('description')
                        ->markdown(),
                        TextEntry::make('deadline')
                            ->label('Deadline'),
                    ])
                    ->collapsed(false), // Set to true to initially collapse the section
    
                Section::make('かだい フアイル')
                    ->description('')
                    ->schema([
                        ImageEntry::make('file_path')
                          ->disk('public')
                          ->label('File')
                          ->url(fn ($record) => asset('storage/' . $record->file_path)),
                            ])
                 ->collapsed(false),
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
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }
}
