<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Message;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'student') {
            $events = $user->registeredEvents()->with('event')->get();
            $messages = Message::where('receiver_id', $user->id)
                ->orWhere('sender_id', $user->id)
                ->latest()
                ->get();
            
            return view('profile.student', compact('user', 'events', 'messages'));
        }
        
        if ($user->role === 'curator') {
            $students = $user->students;
            $events = Event::where('creator_id', $user->id)->get();
            
            return view('profile.curator', compact('user', 'students', 'events'));
        }
        
        return redirect()->route('admin.dashboard');
    }
}