<?php

namespace App\Http\Controllers;

use App\Models\Talk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TalkController extends Controller
{
    public function index()
    {
        $talks = Talk::with('user')->latest()->get();
        return view('home', compact('talks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chat' => 'required|string|max:500',
        ]);

        Talk::create([
            'chat' => $request->chat,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')->with('success', 'Talk posted successfully.');
    }

    public function edit(Talk $talk)
    {
        // Ensure the user owns the talk
        if ($talk->user_id !== Auth::id()) {
            abort(403);
        }

        return view('talks.edit', compact('talk'));
    }

    public function update(Request $request, Talk $talk)
    {
        // Ensure the user owns the talk
        if ($talk->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'chat' => 'required|string|max:500',
        ]);

        $talk->update([
            'chat' => $request->chat,
        ]);

        return redirect()->route('home')->with('success', 'Talk updated successfully.');
    }

    public function destroy(Talk $talk)
    {
        // Ensure the user owns the talk
        if ($talk->user_id !== Auth::id()) {
            abort(403);
        }

        $talk->delete();

        return redirect()->route('home')->with('success', 'Talk deleted successfully.');
    }
}
