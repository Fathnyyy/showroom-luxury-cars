@extends('layouts.app')

@section('title', 'Dashboard - Luxury Car Showroom')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="gradient-bg rounded-2xl p-8 text-center">
            <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                Dashboard
            </h1>
            <p class="text-gray-300 text-lg">Overview of your luxury car showroom</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="glass rounded-xl p-6 shadow-lg border-l-4 border-blue-500 animate-fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Cars</p>
                        <p class="text-3xl font-bold text-white">{{ $totalCars ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="glass rounded-xl p-6 shadow-lg border-l-4 border-green-500 animate-fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Available</p>
                        <p class="text-3xl font-bold text-green-400">{{ $availableCars ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="glass rounded-xl p-6 shadow-lg border-l-4 border-red-500 animate-fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Sold</p>
                        <p class="text-3xl font-bold text-red-400">{{ $soldCars ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="glass rounded-xl p-6 shadow-lg border-l-4 border-yellow-500 animate-fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Reserved</p>
                        <p class="text-3xl font-bold text-yellow-400">{{ $reservedCars ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="glass rounded-xl p-8 mt-8 shadow-lg animate-fade-in">
            <h2 class="text-2xl font-bold text-white mb-6">Car Status Overview</h2>
            <canvas id="carStatusChart" height="100"></canvas>
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('carStatusChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Available', 'Sold', 'Reserved'],
                        datasets: [{
                            data: [{{ $availableCars ?? 0 }}, {{ $soldCars ?? 0 }}, {{ $reservedCars ?? 0 }}],
                            backgroundColor: ['#22c55e', '#ef4444', '#eab308'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#fff',
                                    font: {
                                        size: 16
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        @endpush

        <!-- Recent Cars -->
        <div class="glass rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-white">Recent Cars</h3>
                <a href="{{ route('cars.index') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                    View All
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($recentCars ?? [] as $car)
                    <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition-colors">
                        <div class="flex items-center space-x-3">
                            @if ($car->image)
                                <img src="{{ Storage::url($car->image) }}" alt="{{ $car->brand }}"
                                    class="w-12 h-12 object-cover rounded-lg">
                            @else
                                <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="text-white font-medium">{{ $car->brand }} {{ $car->model }}</h4>
                                <p class="text-gray-400 text-sm">{{ $car->formatted_price }}</p>
                            </div>
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                            @if ($car->status == 'available') bg-green-500 text-white
                            @elseif($car->status == 'sold') bg-red-500 text-white
                            @else bg-yellow-500 text-white @endif">
                                {{ ucfirst($car->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-400">No cars found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="glass rounded-xl p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('cars.create') }}"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="font-medium">Add New Car</span>
                </a>

                <a href="{{ route('cars.index') }}"
                    class="bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <span class="font-medium">View All Cars</span>
                </a>

                <button onclick="exportDashboardPDF()"
                    class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="font-medium">Export Report</span>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Status Chart
                const statusCtx = document.getElementById('statusChart').getContext('2d');
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Available', 'Sold', 'Reserved'],
                        datasets: [{
                            data: [{{ $availableCars ?? 0 }}, {{ $soldCars ?? 0 }},
                                {{ $reservedCars ?? 0 }}
                            ],
                            backgroundColor: ['#10B981', '#EF4444', '#F59E0B'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#D1D5DB',
                                    padding: 20
                                }
                            }
                        }
                    }
                });

                // Brand Chart
                const brandCtx = document.getElementById('brandChart').getContext('2d');
                new Chart(brandCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($brandStats ?? []) !!},
                        datasets: [{
                            label: 'Number of Cars',
                            data: {!! json_encode($brandCounts ?? []) !!},
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#D1D5DB'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#D1D5DB'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#D1D5DB'
                                }
                            }
                        }
                    }
                });
            });

            function exportDashboardPDF() {
                // Implementation for PDF export
                showToast('PDF export feature coming soon!', 'info');
            }
        </script>
    @endpush
