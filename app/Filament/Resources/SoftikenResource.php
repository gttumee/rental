<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftikenResource\Pages;
use App\Filament\Resources\SoftikenResource\RelationManagers;
use App\Models\Softiken;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SoftikenResource extends Resource
{
    protected static ?string $model = Softiken::class;
    protected static ?string $pluralModelLabel = 'Нэмэлт хүсэлт';
    protected static ?string $navigationLabel = 'Нэмэлт хүсэлт';
    protected static ?string $navigationGroup = 'Санал хүсэлт';
    protected static ?string $navigationIcon = 'heroicon-s-heart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Холбоо барих утасны дугаар')
                ->required(), 
                Section::make('Таны санал хүсэл')
                ->description('Та энэхүү талбар энэхүү програм нэмэлтээр оруулах талбар болон бусад алдаа дутагдалын талаар
            бичиж илгээнэ үү')
            ->schema([RichEditor::make('softiken')
            ->disableToolbarButtons([
                'attachFiles',
                'blockquote',
                'codeBlock',
                'h2',
                'h3',
                'redo',
                'strike',
            ])
            ->columnSpanFull()])
                ,
                Hidden::make('user_id')
                ->default(Auth::id()) 
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\CreateSoftiken::route('/'),
            'create' => Pages\CreateSoftiken::route('/create'),
            // 'edit' => Pages\EditSoftiken::route('/{record}/edit'),
        ];
    }
}