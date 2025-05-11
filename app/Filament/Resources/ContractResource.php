<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Apartment;
use App\Models\Contract;
use App\Models\Customer;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint\Operators\IsYearOperator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;


class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $navigationGroup = 'Бүртгэл';
    protected static ?string $navigationIcon = 'heroicon-c-newspaper';
    protected static ?string $pluralModelLabel = 'Гэрээний бүртгэл';
    protected static ?string $navigationLabel = 'Гэрээ байгуулах';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Түрээслэгчийн мэдээлэл')
            ->schema([
            TextInput::make('firstname')
                ->label('Овог')
                ->required(),        
            TextInput::make('lastname')
                ->label('Нэр')
                ->required(),
            TextInput::make('phone_number')
                ->label('Утас')
                ->required(),
            TextInput::make('phone_number_second')
                ->label('Утас2')
                ->required(),
            Textarea::make('other_info')
                ->label('Бусад мэдээлэл')
                ->required()
                ])->columns('2'),

            Section::make('Гэрээний мэдээлэл')
            ->schema([Select::make('apartment_id')
            ->label('Байр')
            ->relationship(
                name: 'apartment',
                titleAttribute: 'name',
            ),   
            TextInput::make('deposit_amount')
                ->label('Барьцаа')
                ->numeric()
                ->required(),     
            TextInput::make('rent_amount')
                ->label('Түрээс')
                ->numeric()
                ->required(),
            TextInput::make('late_fee_amount')
                ->label('Алданги хувь')
                ->numeric()
                ->required(),
            TextInput::make('payment_schedule')
                ->label('Түрээс төлөх өдөр')
                ->required()
                ->default('25'),
            DatePicker::make('contract_start_date')
                ->label('Гэрэээ байгуулсан огноо')
                ->required()
                ->default(now()),
            DatePicker::make('contract_end_date')
                ->label('Гэрэээ дуусах огноо')
                ->required()
                ->default(now()),
            Select::make('status')
                ->label('Status')
                ->options([
                1 => 'Түрээсэлсэн',
                2 => 'Түрээсэлээгүй',
                3 => 'Түр хүлээлгэх',
                4 => 'Засвар хийх',
                ])
                ->default('1'),
            Textarea::make('contract_other_info')
                ->label('Бусад мэдээлэл')
                ->required(),
            ])->columns('2'),
            Hidden::make('user_id')
            ->default(Auth::id()) 
            ->required(),
        ]);
        
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lastname')
                ->label('Түрээслэгч'),
                TextColumn::make('apartment.name')
                ->label('Үл хөдлөхийн нэр'),
                TextColumn::make('rent_amount')
                ->summarize(
                    Sum::make()
                    ->numeric()->label('Нийт'))
                ->label('Түрээс')
                ->numeric(),
                TextColumn::make('deposit_amount')
                ->summarize(
                    Sum::make()
                    ->numeric()->label('Нийт'))
                ->label('Барьцаа')
                ->numeric(),
                TextColumn::make('payment_schedule')
                ->label('Төлөлтийн өдөр'),
                BadgeColumn::make('status')
                ->formatStateUsing(fn ($state) => match ($state) {
                    1 => 'Түрээслэгчтэй', 
                    2 => 'Түрээслэгчтгүй', 
                    3 => 'Засвартай', 
                })
                ->colors([
                    'success' => 1,
                    'primary' => 2,
                    'danger' => 3,  
                ])
                ->label('Статус'),
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}