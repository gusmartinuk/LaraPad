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

        $note = Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'is_pinned' => $request->has('is_pinned'),
        ]);

        // Attach tags
        $tags = explode(',', $request->tags);
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $note->tags()->attach($tag->id);
        }

        return redirect()->route('notes.index')->with('success', 'Note added with tags!');
    }


    public function update(Request $request, Note $note)
    {
        // Check user authorization
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Remove old images from storage
        $oldContent = $note->content;
        $pattern = '/<img[^>]+src="\/storage\/([^"]+)"[^>]*>/i';
        if (preg_match_all($pattern, $oldContent, $oldImages)) {
            foreach ($oldImages[1] as $filePath) {
                Storage::delete('public/' . $filePath);
            }
        }

        // Process new content and save images
        $contentWithSavedImages = \App\Helpers\ContentHelper::handleImages($request->content);

        // Update note
        $note->update([
            'title' => $request->title,
            'content' => $contentWithSavedImages,
            'is_pinned' => $request->has('is_pinned'),
        ]);

        // Update tags
        $note->tags()->detach();
        $tags = explode(',', $request->tags);
        foreach ($tags as $tagName) {
            $tag = \App\Models\Tag::firstOrCreate(['name' => trim($tagName)]);
            $note->tags()->attach($tag->id);
        }

        return redirect()->route('notes.index')->with('success', 'Note updated successfully with tags and cleaned images!');
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

    public function filterByTag(Tag $tag)
    {
        $notes = $tag->notes()->paginate(6);
        return view('notes.index', compact('notes'));
    }



}
