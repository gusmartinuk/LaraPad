@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">🏷️ Manage Tags</h1>

    <!-- Add New Tag -->
    <form action="{{ route('tags.store') }}" method="POST" class="mb-6">
        @csrf
        <div class="flex space-x-2">
            <input type="text" name="name" placeholder="Enter new tag" required
                   class="w-full border-gray-300 p-2 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ➕ Add Tag
            </button>
        </div>
    </form>

    <!-- Existing Tags -->
    <div class="mt-4">
        @forelse($tags as $tag)
            <div class="flex justify-between items-center border-b py-2">
                <span>#{{ $tag->name }}</span>
                <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" onsubmit="return confirm('Delete this tag?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800">🗑️ Delete</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">No tags found.</p>
        @endforelse
    </div>
</div>
@endsection
