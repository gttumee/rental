<?php

namespace App\Filament\Resources\SoftikenResource\Pages;

use App\Filament\Resources\SoftikenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoftikens extends ListRecords
{
    protected static string $resource = SoftikenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
