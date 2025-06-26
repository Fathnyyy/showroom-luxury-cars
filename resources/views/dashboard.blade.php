@extends('layouts.app')

@section('title', 'Dashboard 2 - Luxury Car Showroom')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 space-y-10">

    <!-- Header -->
    <div class="rounded-xl p-8 text-center shadow bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-400">
        <h1 class="text-3xl font-extrabold mb-2 text-white tracking-wide animate-fade-in">
            <i class="fas fa-gauge-high mr-2"></i> Dashboard Overview
        </h1>
        <p class="text-white/80 text-base">All your luxury car showroom stats at a glance</p>
    </div>
   <!-- Statistik & Car Status Overview dalam 1 Card (tinggi sama) -->
<div class="bg-white border border-gray-200 rounded-2xl shadow p-10 flex flex-col md:flex-row items-stretch justify-between gap-10 my-10 max-w-6xl mx-auto">
    <!-- Car Status Overview (Ungu) -->
    <div class="bg-purple-100 border border-purple-300 rounded-xl flex flex-col items-center justify-center p-8 shadow h-full min-h-[260px]">
        <h2 class="text-base font-semibold text-purple-800 mb-4">Car Status</h2>
        <canvas id="carStatusChart" width="180" height="180" style="max-width:180px;max-height:180px;"></canvas>
    </div>
    <!-- Statistik Ringkas -->
    <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-8 h-full">
        <div class="bg-blue-100 border border-blue-300 p-8 rounded-lg shadow text-center flex flex-col justify-center h-full">
            <div class="text-3xl mb-2 text-blue-500"><i class="fas fa-car"></i></div>
            <div class="text-3xl font-bold text-gray-800">{{ $totalCars }}</div>
            <div class="text-base text-gray-500">Total Cars</div>
        </div>
        <div class="bg-green-100 border border-green-300 p-8 rounded-lg shadow text-center flex flex-col justify-center h-full">
            <div class="text-3xl mb-2 text-green-500"><i class="fas fa-check-circle"></i></div>
            <div class="text-3xl font-bold text-gray-800">{{ $availableCars }}</div>
            <div class="text-base text-gray-500">Available</div>
        </div>
        <div class="bg-yellow-100 border border-yellow-300 p-8 rounded-lg shadow text-center flex flex-col justify-center h-full">
            <div class="text-3xl mb-2 text-yellow-500"><i class="fas fa-clock"></i></div>
            <div class="text-3xl font-bold text-gray-800">{{ $reservedCars }}</div>
            <div class="text-base text-gray-500">Reserved</div>
        </div>
        <div class="bg-pink-100 border border-pink-300 p-8 rounded-lg shadow text-center flex flex-col justify-center h-full">
            <div class="text-3xl mb-2 text-pink-500"><i class="fas fa-dollar-sign"></i></div>
            <div class="text-3xl font-bold text-gray-800">{{ $soldCars }}</div>
            <div class="text-base text-gray-500">Sold</div>
        </div>
    </div>
</div>
<!-- Mobil Terbaru -->
<div class="bg-sky-50 border border-sky-200 rounded-xl p-8 shadow">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Cars</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($recentCars as $car)
            <div class="bg-white border border-blue-100 rounded-lg shadow p-4 flex flex-col items-center hover:scale-105 transition">
                <img src="{{ $car->image ? Storage::url($car->image) : 'https://via.placeholder.com/120x80' }}"
                     class="w-28 h-20 object-cover rounded mb-2 border-2 border-blue-400 shadow">
                <div class="font-semibold text-gray-800">{{ $car->brand }} {{ $car->model }}</div>
                <div class="text-xs text-gray-500 mb-1">{{ $car->year }}</div>
                <span class="text-xs px-2 py-0.5 rounded
                    @if($car->status == 'available') bg-green-100 text-green-700
                    @elseif($car->status == 'sold') bg-pink-100 text-pink-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ ucfirst($car->status) }}
                </span>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-400">No recent cars.</div>
        @endforelse
    </div>
</div>

<!-- Aktivitas Terbaru -->
<div class="bg-gray-100 border border-gray-300 rounded-xl p-8 shadow">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h2>
    <table class="w-full text-sm text-gray-700">
        <thead>
            <tr>
                <th class="py-2 px-2 text-left">Time</th>
                <th class="py-2 px-2 text-left">User</th>
                <th class="py-2 px-2 text-left">Activity</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentActivities as $activity)
                <tr class="border-t">
                    <td class="py-2 px-2">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</td>
                    <td class="py-2 px-2">{{ $activity->user->name ?? '-' }}</td>
                    <td class="py-2 px-2">{{ $activity->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-2 px-2 text-center text-gray-400">No recent activities.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- Chart.js for chart -->
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
                legend: { labels: { color: '#222', font: { size: 14 } } }
            }
        }
    });
</script>
</script>
@endpush
