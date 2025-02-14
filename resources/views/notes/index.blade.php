@extends('layouts.app')

@section('content')

<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Navigation -->
    <div class="w-full md:w-64">
        @include('layouts.navigation')
    </div>

    <div class="p-4 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">🗒️ My Notes</h1>

        <!-- Add New Note Button -->
        <button onclick="openNoteModal()"
                class="bg-green-600 text-white px-4 py-2 mb-6 rounded shadow hover:bg-green-700">
            ➕ Add New Note
        </button>

        <!-- Notes Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($notes as $note)
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-blue-400 hover:scale-105 transition relative">
                <!-- Başlık -->
                <h3 class="font-semibold text-lg mb-3">{{ $note->title }}</h3>

                <!-- İçerik Özeti -->
                <p class="text-sm text-gray-700 mb-4">
                    {{ Str::limit(strip_tags($note->content), 150) }}
                </p>

                <!-- İşlem Butonları -->
                <div class="flex justify-between items-center border-t pt-2 text-sm">
                    <!-- Edit Button -->
                    <button onclick="openNoteModal({{ $note->id }}, '{{ $note->title }}', `{!! $note->content !!}`, {{ $note->is_pinned }})"
                            class="text-blue-600 hover:text-blue-800 flex items-center">
                        ✏️ <span class="ml-1">Edit</span>
                    </button>

                    <!-- Delete Button -->
                    <button onclick="confirmDelete({{ $note->id }})" class="text-red-500 hover:text-red-700 flex items-center">
                        🗑️ <span class="ml-1">Delete</span>
                    </button>
                </div>

                <!-- Delete Form -->
                <form id="deleteForm-{{ $note->id }}" action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @empty
            <p>No notes found.</p>
        @endforelse
        </div>


    </div>
</div>

<!-- Modal for Add/Edit Note -->
<div id="noteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
        <h2 id="modalTitle" class="text-xl font-bold mb-4">📝 Add New Note</h2>
        <form id="noteForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block font-medium">Title:</label>
                <input type="text" name="title" id="modalTitleInput" required
                       class="w-full border-gray-300 p-2 rounded shadow-sm">
            </div>

            <!-- Content (HTML Editor) -->
            <div class="mb-4">
                <label class="block font-medium">Content:</label>
                <div id="editor" class="border p-2 rounded min-h-[200px]"></div>
                <textarea name="content" id="content" class="hidden"></textarea>
            </div>

            <!-- Pin Note Checkbox -->
            <div class="mb-4">
                <label for="is_pinned" class="inline-flex items-center">
                    <input type="checkbox" name="is_pinned" id="isPinned" class="form-checkbox text-blue-600">
                    <span class="ml-2">📌 Pin this note</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeNoteModal()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save Note
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Quill.js -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write your note...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    const contentField = document.getElementById('content');
    quill.on('text-change', () => {
        contentField.value = quill.root.innerHTML;
    });

    function openNoteModal(id = null, title = '', content = '', isPinned = false) {
        const modal = document.getElementById('noteModal');
        const form = document.getElementById('noteForm');
        const titleInput = document.getElementById('modalTitleInput');
        const isPinnedCheckbox = document.getElementById('isPinned');
        const modalTitle = document.getElementById('modalTitle');
        const methodInput = document.getElementById('formMethod');

        // Reset form and editor
        titleInput.value = title;
        quill.root.innerHTML = content;
        isPinnedCheckbox.checked = isPinned;

        // Set form action and method based on context
        if (id) {
            form.action = `/notes/${id}`;
            methodInput.value = 'PUT';
            modalTitle.textContent = '✏️ Edit Note';
        } else {
            form.action = `/notes`;
            methodInput.value = 'POST';
            modalTitle.textContent = '📝 Add New Note';
        }

        modal.classList.remove('hidden');
    }

    function closeNoteModal() {
        document.getElementById('noteModal').classList.add('hidden');
    }
</script>

<script>
    function confirmDelete(noteId) {
        if (confirm('Are you sure you want to delete this note?')) {
            document.getElementById(`deleteForm-${noteId}`).submit();
        }
    }
</script>


@endsection

