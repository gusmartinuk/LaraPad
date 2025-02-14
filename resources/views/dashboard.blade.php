@extends('layouts.app')

@section('content')

<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Navigation -->
    <div class="w-full md:w-64">
        @include('layouts.navigation')
    </div>

    <!-- Dashboard Content -->
    <div class="flex-1 p-4 bg-gray-100">
        <h1 class="text-2xl font-bold mb-6">📊 Dashboard</h1>

        <!-- Notes Section -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-4">🗒️ Recent Notes</h2>
            <ul class="space-y-3">
                @forelse($notes as $note)
                    <li class="bg-white p-4 shadow-lg rounded-md border-l-4 border-blue-500">
                        <strong>{{ $note->title }}</strong>
                        <p class="text-sm text-gray-600">{{ Str::limit($note->content, 60) }}</p>
                    </li>
                @empty
                    <li class="text-gray-500">No notes found.</li>
                @endforelse
            </ul>
        </div>

        <!-- Tags Chart -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-4">🏷️ Tag Distribution</h2>
            <canvas id="tagChart" class="w-full h-64"></canvas>
        </div>

        <!-- Documents Section -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-4">📂 Recent Documents</h2>
            <ul class="space-y-3">
                @forelse($documents as $doc)
                    <li class="bg-white p-4 shadow-lg rounded-md border-l-4 border-green-500">
                        <strong>{{ $doc->filename }}</strong> - {{ $doc->file_type }}
                    </li>
                @empty
                    <li class="text-gray-500">No documents available.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('tagChart').getContext('2d');
    const tagChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($tagLabels) !!},
            datasets: [{
                data: {!! json_encode($tagCounts) !!},
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF9800']
            }]
        }
    });
</script>
@endsection
