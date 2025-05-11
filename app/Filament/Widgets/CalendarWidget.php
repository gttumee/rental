<?php
// CalendarWidget.php
namespace App\Filament\Widgets;

use App\Models\Contract;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Contract::class;

    public function fetchEvents(array $fetchInfo): array
    {
       return
         Contract::query()
            ->where('contract_start_date', '>=', $fetchInfo['start'])
            ->where('contract_end_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Contract $event) => [
                    'title' => $event->apartment ? $event->apartment->name . ' ' . $event->apartment->number_of_rooms . 'тоот' : 'задгай', // Apartmentからnameとnumber_of_roomsを取得してtitleに表示
                    'start' => Carbon::parse($event->contract_start_date)->day($event->payment_schedule),
                    'end' => Carbon::parse($event->contract_end_date)->day($event->payment_schedule),   
                    'id' => $event->id, 
                ]
            )
      
            ->all();

    }
    public function eventDidMount(): string
{
    return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
        }
    JS;
}    
}