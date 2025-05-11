<?php

namespace App\Filament\Widgets;

use App\Models\Apartment;
use App\Models\Contract;
use App\Models\Customer;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Mockery\Matcher\Contains;

class RentalWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Орлого', Contract::where('status', 1)->sum('rent_amount'). '₮')
            ->description('Энэ сарын орлого')
            ->color('success')
            ->descriptionIcon('heroicon-c-newspaper', IconPosition::Before),
           stat::make('Байр', Apartment::count())
           ->description('Одоогийн нийт байр')
           ->color('success')
           ->descriptionIcon('heroicon-s-building-office-2',IconPosition::Before),
           stat::make('Гэрээ',Contract::count())
           ->description('Нийт идэвхтэй гэрээ')
           ->color('success')
           ->descriptionIcon('heroicon-c-newspaper',IconPosition::Before),
        ];
    }
}