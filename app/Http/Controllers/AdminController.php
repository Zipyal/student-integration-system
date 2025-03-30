<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function dashboard()
    {
        $stats = [
            'students' => User::where('role', 'student')->count(),
            'curators' => User::where('role', 'curator')->count(),
            'events' => Event::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::with('curator')
            ->orderBy('role')
            ->paginate(15);
            
        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        $curators = User::where('role', 'curator')->get();
        return view('admin.users.edit', compact('user', 'curators'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:student,curator,admin',
            'curator_id' => 'nullable|exists:users,id'
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users')->with('success', 'Пользователь обновлен');
    }
}