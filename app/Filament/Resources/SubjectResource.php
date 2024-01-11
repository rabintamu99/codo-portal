<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectResource extends Resource
{
    public static function registerNavigation(): array
    {
        $subjects = Subject::all();
        $navigationItems = [];

        foreach ($subjects as $subject) {
            $navigationItems[] = [
                'label' => $subject->name,
                'url' => route('filament.resources.subjects.assignments', ['subject' => $subject->id]),
                'icon' => 'heroicon-o-academic-cap',
            ];
        }

        return $navigationItems;
    }
    public static function getLabel(): string
    {
        return 'Subject';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-academic-cap'; // choose an appropriate icon
    }

    protected static ?string $model = Subject::class;
    protected static ?string $navigationGroup = 'setting';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')->required(),
                Forms\Components\TextInput::make('name'),
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
