<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Список мероприятий
    public function index()
    {
        $events = Event::upcoming()
            ->withCount('registrations')
            ->paginate(10);
            
        return view('events.index', compact('events'));
    }

    // Просмотр мероприятия
    public function show(Event $event)
    {
        $isRegistered = auth()->check() && 
            Registration::where('user_id', auth()->id())
                ->where('event_id', $event->id)
                ->exists();
                
        return view('events.show', compact('event', 'isRegistered'));
    }

    // Запись на мероприятие
    public function register(Request $request, Event $event)
    {
        if ($event->max_participants && 
            $event->registrations()->count() >= $event->max_participants) {
            return back()->with('error', 'Мест больше нет');
        }
        
        Registration::firstOrCreate([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);
        
        return back()->with('success', 'Вы успешно зарегистрировались');
    }

    // Отмена записи
    public function cancelRegistration(Event $event)
    {
        Registration::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->delete();
            
        return back()->with('success', 'Запись отменена');
    }
}