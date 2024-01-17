<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'ユーザー管理';

    protected static ?string $navigationLabel = 'ユーザー';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'ユーザー';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Forms\Components\TextInput::make('id')->required(),
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('student_id')->required(),
                Forms\Components\TextInput::make('password')->required(),
                Forms\Components\Select::make('roles')->multiple()->relationship('roles', 'name'),
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('名前')
                ->searchable(),
                Tables\Columns\TextColumn::make('student_id')
                ->label('学籍番号')
                ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                ->label('ロール')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    
}
