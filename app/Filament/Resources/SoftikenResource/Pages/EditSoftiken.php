<?php

namespace App\Filament\Resources\SoftikenResource\Pages;

use App\Filament\Resources\SoftikenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSoftiken extends EditRecord
{
    protected static string $resource = SoftikenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
