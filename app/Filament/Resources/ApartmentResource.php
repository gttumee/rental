<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApartmentResource\Pages;
use App\Models\Apartment;
use App\Models\Contract;
use App\Models\User;
use Filament\Tables\Columns\Summarizers\Range;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class ApartmentResource extends Resource
{
    protected static ?string $model = Apartment::class;
    protected static ?string $navigationGroup = 'Бүртгэл';
    protected static ?string $navigationIcon = 'heroicon-s-building-office-2';
    protected static ?string $pluralModelLabel = 'Үл хөдлөх бүртгэл';
    protected static bool $hasTitleCaseModelLabel = false;
    protected static ?string $navigationLabel = 'Үл хөдлөх бүртгэл';

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Байр хотхон нэр')
                ->placeholder('Хүннү хотхон')
                ->required(),
                TextInput::make('address')
                ->label('Хаяг байршил')
                ->placeholder('БЗД 5-р хороо 15 хороолол')
                ->nullable(),
                TextInput::make('number_of_rooms')
                ->label('Тоот')
                ->placeholder('61')
                ->numeric()
                ->nullable(),
                TextInput::make('size')
                ->label('Хэмжээ м2')
                ->placeholder('100')
                ->numeric()
                ->nullable(),
                Select::make('status')
                ->label('Статус')
                ->options([
                    1 => 'Орон сууц',
                    2 => 'Хашаа байшин',
                    3 => 'Бусад',
                ])
                ->default(1)
                ->nullable(),
                DatePicker::make('Сүүлд засвар хийсэн')
                ->label('Сүүлд засвар хийсэн')
                ->nullable(),
                Textarea::make('other_info')
                ->label('Бусад мэдээлэл')
                ->nullable(),
                FileUpload::make('file')
                ->label('Зураг')
                ->multiple()
                ->placeholder('Зураг оруулах')
                ->nullable(),
                Hidden::make('user_id')
                ->default(Auth::id()) 
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Байр хотхон нэр'),
                TextColumn::make('address')->label('Хаяг'),
                TextColumn::make('number_of_rooms')->label('Тоот'),
                BadgeColumn::make('status')
                ->formatStateUsing(fn ($state) => match ($state) {
                    1 => 'Орон сууц', 
                    2 => 'Хашаа байшин', 
                    3 => 'Бусад', 
                })
                ->colors([
                    'success' => 1,
                    'primary' => 2,
                    'danger' => 3,  
                ])
                ->label('Статус'),
                TextColumn::make('rent_price')
                ->label('Түрээсийн үнэ')
                ->numeric(),
                TextColumn::make('other_info')->label('Бусад'),
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
            'index' => Pages\ListApartments::route('/'),
            'create' => Pages\CreateApartment::route('/create'),
            'edit' => Pages\EditApartment::route('/{record}/edit'),
        ];
    }
}