<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Filament\Resources\AssignmentResource\RelationManagers;
use Filament\Forms\Components\RichEditor;
use App\Models\Assignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Classes';

    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\RichEditor::make('description'),
                Forms\Components\DateTimePicker::make('deadline'),
                Forms\Components\FileUpload::make('file_path'),
                // Forms\Components\TextInput::make('subject'),
                // Forms\Components\Select::make('subject_id')
                // ->relationship('subject', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->searchable(),
                Tables\Columns\TextColumn::make('description')
                ->searchable(),
                Tables\Columns\TextColumn::make('deadline')
                ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject')->options([
                    'C Programming' => 'C Programming',
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

 
    public static function infolist(Infolist $infolist): Infolist
    {
          return $infolist
             ->schema([      
              TextEntry::make('title'),
              TextEntry::make('description'),
              TextEntry::make('deadline'),
              ImageEntry::make('file_path')
              ->disk('public'),
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
