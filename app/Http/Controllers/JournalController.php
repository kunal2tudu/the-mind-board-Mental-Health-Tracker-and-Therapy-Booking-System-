<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $entries = auth()->user()->journalEntries()->latest()->get();
        return view('journal.index', compact('entries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        JournalEntry::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('journal.index')->with('status', 'Journal entry saved!');
    }
}
