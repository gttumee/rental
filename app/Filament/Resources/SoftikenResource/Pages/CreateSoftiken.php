<?php

namespace App\Filament\Resources\SoftikenResource\Pages;

use App\Filament\Resources\SoftikenResource;
use App\Models\Softiken;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSoftiken extends CreateRecord
{
    protected static string $resource = SoftikenResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        $recipient = auth()->user()->name;
        $phone = Softiken::first()->name;
        return Notification::make()
        ->title('Хүсэлт амжилттай илгээгдлээ')
        ->success()
        ->duration(50000)
        ->body($recipient.'таньд хүсэлт илгээсэнд баярлалаа таны саналыг бид судалж үзээд таны энэ дугаарт'.$phone.' барих болно')
        ->send();   
    }
}