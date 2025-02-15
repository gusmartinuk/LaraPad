<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Display all tags
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('tags.index', compact('tags'));
    }

    // Add a new tag
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name',
        ]);

        Tag::create(['name' => $request->name]);

        return redirect()->route('tags.index')->with('success', 'Tag added successfully!');
    }

    // Delete a tag
    public function destroy(Tag $tag)
    {
        if ($tag->notes()->exists()) {
            return redirect()->route('tags.index')->with('error', 'Cannot delete tag attached to notes!');
        }

        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $tags = Tag::where('name', 'like', "%{$query}%")->get();
        return response()->json($tags);
    }
}
