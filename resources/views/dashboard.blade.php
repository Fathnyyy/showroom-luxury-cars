@extends('layouts.app')

@section('title', 'Dashboard - Luxury Car Showroom')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="gradient-bg rounded-2xl p-8 text-center">
        <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
            Dashboard
        </h1>
        <p class="text-gray-300 text-lg">Welcome to your luxury car showroom dashboard</p>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="glass p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-blue-400">{{ $totalCars }}</div>
            <div class="text-gray-300 mt-2">Total Cars</div>
        </div>
        <div class="glass p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-green-400">{{ $availableCars }}</div>
            <div class="text-gray-300 mt-2">Available</div>
        </div>
        <div class="glass p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-yellow-400">{{ $reservedCars }}</div>
            <div class="text-gray-300 mt-2">Reserved</div>
        </div>
        <div class="glass p-6 rounded-xl shadow text-center">
            <div class="text-3xl font-bold text-pink-400">{{ $soldCars }}</div>
            <div class="text-gray-300 mt-2">Sold</div>
        </div>
    </div>

    <!-- Grafik Status Mobil -->
    <div class="glass p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4 text-white">Car Status Overview</h2>
        <canvas id="carStatusChart" height="100"></canvas>
    </div>

    <!-- Mobil Terbaru -->
    <div class="glass p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4 text-white">Recent Cars</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($recentCars as $car)
                <div class="bg-gray-800 rounded-lg shadow-lg p-4 flex flex-col items-center hover:scale-105 transition">
                    <img src="{{ $car->image ? Storage::url($car->image) : 'https://via.placeholder.com/150' }}"
                         class="w-32 h-24 object-cover rounded mb-3 border-2 border-blue-400 shadow">
                    <div class="text-lg font-semibold text-white">{{ $car->brand }} {{ $car->model }}</div>
                    <div class="text-gray-400 text-sm mb-1">{{ $car->year }}</div>
                    <span class="px-2 py-1 rounded-full text-xs font-bold
                        @if($car->status == 'available') bg-green-500/80 text-white
                        @elseif($car->status == 'sold') bg-pink-500/80 text-white
                        @else bg-yellow-400/80 text-gray-900 @endif">
                        {{ ucfirst($car->status) }}
                    </span>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-400">No recent cars.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('carStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Reserved', 'Sold'],
            datasets: [{
                data: [{{ $availableCars }}, {{ $reservedCars }}, {{ $soldCars }}],
                backgroundColor: [
                    'rgba(34,197,94,0.7)',    // green
                    'rgba(253,224,71,0.7)',   // yellow
                    'rgba(236,72,153,0.7)'    // pink
                ],
                borderWidth: 2,
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: '#fff', font: { size: 16 } } }
            }
        }
    });
</script>
@endpush
