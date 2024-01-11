<?php

namespace App\Filament\Widgets;
use Filament\Forms;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Event::class;
 
    public function fetchEvents(array $fetchInfo): array
    {
        return Event::where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Event $event) {
                return [
                    'id'    => $event->id,
                    'title' => $event->name,
                    'start' => $event->start,
                    'end'   => $event->end,
                ];
            })
            ->toArray();
    }
    

    public function getFormSchema(): array
    {
        return [
           

            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\DateTimePicker::make('start'),
                    Forms\Components\DateTimePicker::make('end'),
                ]),
        ];
    }
 
    public static function canView(): bool
    {
        return false;
    }
}