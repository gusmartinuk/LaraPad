<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Tag;
use App\Models\Document;
use App\Helpers\ContentHelper;
use Illuminate\Support\Facades\Storage;


class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())->latest()->get();
        return view('notes.index', compact('notes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $contentWithSavedImages = ContentHelper::handleImages($request->content);

        Note::create([
            'title' => $request->title,
            'content' => $contentWithSavedImages,
            'user_id' => auth()->id(),
            'is_pinned' => $request->has('is_pinned')
        ]);

        return redirect()->route('notes.index')->with('success', 'Note added!');
    }

    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Process old content and delete images
        $oldContent = $note->content;
        $pattern = '/<img[^>]+src="\/storage\/([^"]+)"[^>]*>/i';
        if (preg_match_all($pattern, $oldContent, $oldImages)) {
            foreach ($oldImages[1] as $filePath) {
                Storage::delete('public/' . $filePath);
            }
        }

        // New content with saved images
        $contentWithSavedImages = ContentHelper::handleImages($request->content);

        // Update note
        $note->update([
            'title' => $request->title,
            'content' => $contentWithSavedImages,
            'is_pinned' => $request->has('is_pinned'),
        ]);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        // User validation
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Content contains images, delete them
        $pattern = '/<img[^>]+src="\/storage\/([^"]+)"[^>]*>/i';
        if (preg_match_all($pattern, $note->content, $matches)) {
            foreach ($matches[1] as $filePath) {
                Storage::delete('public/' . $filePath);
            }
        }

        // Delete note
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }



}
