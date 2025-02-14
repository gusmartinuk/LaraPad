@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">📝 Create New Note</h1>

    <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Note Title -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2"
                   required>
        </div>
        <div class="mb-4">
            <label for="is_pinned" class="inline-flex items-center">
                <input type="checkbox" name="is_pinned" id="is_pinned" class="form-checkbox text-blue-600">
                <span class="ml-2">📌 Pin this note</span>
            </label>
        </div>

        <!-- Note Content (HTML Editor) -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Content</label>
            <div id="editor" class="border border-gray-300 rounded-md p-2 min-h-[300px]"></div>
            <textarea name="content" id="content" class="hidden"></textarea>
        </div>


        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Note
            </button>
        </div>
    </form>
</div>

<!-- Quill JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write your note here...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'image', 'code-block'],
                ['clean']
            ]
        }
    });

    // Sync content with hidden textarea
    const contentField = document.getElementById('content');
    quill.on('text-change', () => {
        contentField.value = quill.root.innerHTML;
    });
</script>
@endsection
