<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Ажилтан нэмэх';
    protected static ?string $pluralModelLabel = 'Хэрэглэгч нэмэх';
    protected static ?string $navigationLabel = 'Хэрэглэгч нэмэх';
    protected static ?string $navigationIcon = 'heroicon-c-user-plus';
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required() 
                ->label('Нэр')
                ->maxLength(255), 
                TextInput::make('email')
                ->required() 
                ->email() 
                ->label('И-мэйл')
                ->maxLength(255),                        
                TextInput::make('password')
                ->required() 
                ->password()
                ->revealable()
                ->label('Нууц үг')
                ->maxLength(255),                          
                Hidden::make('company_id')
                ->default(auth()->user()->company_id) 
                ->required(),
                Hidden::make('company_name')
                ->default(auth()->user()->company_name) 
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(User::where('company_id', Auth::user()->company_id)) 
            ->columns([
                TextColumn::make('name')
                ->label('Нэр'),
                TextColumn::make('email')
                ->label('Нэвтрэх нэр'),
                TextColumn::make('company_name')
                ->label('Комани')
                ->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                ->label('Бүгдийн устгах'),
                ])->label('Устгах'),
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