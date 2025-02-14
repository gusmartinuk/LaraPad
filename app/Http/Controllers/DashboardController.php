<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Tag;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch recent notes
        $notes = Note::latest()->take(5)->get();

        // Calculate tag distribution
        $tags = Tag::withCount('notes')->get();
        $tagLabels = $tags->pluck('name');
        $tagCounts = $tags->pluck('notes_count');

        // Fetch recent documents
        $documents = Document::latest()->take(5)->get();

        // Pass variables to the view
        return view('dashboard', compact('notes', 'tagLabels', 'tagCounts', 'documents'));
    }
}
