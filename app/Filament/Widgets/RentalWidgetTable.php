<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RentalWidgetTable extends BaseWidget
{
    protected static ?string $heading = 'Энэ сард түрээс төлөгдөх байр';
    protected static string $color = 'info';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Contract::query('customer.name,apartment.name')
            )
            ->columns([
                Tables\Columns\TextColumn::make('lastname')
                ->label('Түрээслэгч'),
                Tables\Columns\TextColumn::make('apartment.name')
                ->label('Байр'),
                Tables\Columns\TextColumn::make('rent_amount')
                ->label('Мөнгөн дүн'),
                Tables\Columns\TextColumn::make('payment_schedule')
                ->label('Төлөх өдөр'),
            ]);
    }
}